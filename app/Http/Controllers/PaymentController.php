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
            'amount' => 'nullable|numeric|min:1450',
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
        $request->validate([
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:1000',
        ]);

        $paypack = new Paypack();
        $paypack->config([
            'client_id' => config('services.paypack.client_id'),
            'client_secret' => config('services.paypack.client_secret'),
        ]);

        // Step 1: Initiate cashin
        $cashin = $paypack->Cashin([
            'phone' => $request->get('phone'),
            'amount' => $request->get('amount', 100), // Set default/test amount to 100 RWF
        ]);

        // Step 2: Poll for transaction status using ref
        $ref = $cashin['ref'] ?? null;
        $transaction = null;
        if ($ref) {
            // Try to get the transaction status (simulate polling, but just one call here)
            $transactions = $paypack->Transactions([
                'offset' => 0,
                'limit' => 100,
            ]);
            if (is_array($transactions)) {
                foreach ($transactions as $tx) {
                    if (isset($tx['ref']) && $tx['ref'] === $ref) {
                        $transaction = $tx;
                        break;
                    }
                }
            }
        }

        // Step 3: Store payment data in DB
        $paymentData = [
            'amount' => $transaction['amount'] ?? $cashin['amount'] ?? $request->get('amount', 100),
            'client' => $transaction['client'] ?? $request->get('phone'),
            'kind' => $transaction['kind'] ?? $cashin['kind'] ?? 'cashin',
            'merchant' => $transaction['merchant'] ?? null,
            'ref' => $ref,
            'status' => $transaction['status'] ?? $cashin['status'] ?? 'pending',
            'timestamp' => $transaction['timestamp'] ?? $cashin['created_at'] ?? now(),
        ];
        $payment = Payment::create($paymentData);

        // Step 4: If payment is successful and amount is 100, update/create subscription
        if (($payment->amount == 100) && ($payment->status === 'successful')) {
            $user = $payment->user;
            if ($user) {
                $start = now();
                $end = now()->addDays(31);
                $user->subscription()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'start_date' => $start,
                        'end_date' => $end,
                    ]
                );
            }
        }

        return response()->json([
            'payment' => $payment,
            'transaction' => $transaction,
            'cashin' => $cashin,
        ]);
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
