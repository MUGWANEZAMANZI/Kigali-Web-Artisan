<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Paypack\Paypack;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        // Validate request parameters
        $request->validate([
            'phone' => 'required|string',
            'amount' => 'nullable|numeric|min:1000',
        ]);

        // Initialize Paypack with configuration
        $paypack = new Paypack();
        $paypack->config([
            'client_id' => env('PAYPACK_CLIENT_ID'),
            'client_secret' => env('PAYPACK_CLIENT_SECRET'),
        ]);

        // Return the payment form view with necessary data
        return response()->json([
            'phone' => $request->get('phone'),
            'amount' => $request->get('amount', 1000),
            'paypack_config' => $paypack->config(),
        ]);
    }

    public function pay(Request $request) : JsonResponse
    {
        $paypack = new Paypack();
        $paypack->config([
            'client_id' => env('PAYPACK_CLIENT_ID'),
            'client_secret' => env('PAYPACK_CLIENT_SECRET'),
        ]);

        $cashin = $paypack->Cashin([
            'phone' => $request->get('phone'),
            'amount' => $request->get('amount', '1000'),
        ]);

        // Store payment data if transaction
        $payment = Payment::create([
            'amount' => $cashin['amount'] ?? $request->get('amount', '1000'),
            'client' => $cashin['client'] ?? $request->get('phone'),
            'kind' => $cashin['kind'] ?? 'cashin',
            'merchant' => $cashin['merchant'] ?? null,
            'ref' => $cashin['ref'] ?? null,
            'status' => $cashin['status'],
            'timestamp' => $cashin['timestamp'] ?? now(),
        ]);

        // If payment is 1000 and successful, create or update subscription
        if (($payment->amount == 1000) && ($payment->status === 'success')) {
            $user = $payment->user;
            if ($user) {
                $start = now();
                $end = now()->addDays(31);
                // Create or update subscription
                $user->subscription()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'start_date' => $start,
                        'end_date' => $end,
                    ]
                );
            }
        }


        return response()->json($cashin);
    }

    public function status(Request $request) : JsonResponse
    {
        $paypack = new Paypack();
        $paypack->config([
            'client_id' => env('PAYPACK_CLIENT_ID'),
            'client_secret' => env('PAYPACK_CLIENT_SECRET'),
        ]);

        $transactions = $paypack->Transactions([
            'offset' => $request->get('offset', 0),
            'limit' => $request->get('limit', 100),
        ]);

        // Optionally, fetch a single transaction if ref is provided
        $transaction = null;
        if ($request->has('ref')) {
            $transaction = $paypack->Transaction($request->get('ref'));
        }

        return response()->json([
            'transactions' => $transactions,
            'transaction' => $transaction,
        ]);
    }
}
