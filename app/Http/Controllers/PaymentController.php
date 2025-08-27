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
            'months' => 'required|numeric|min:1|max:12',
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
            'months' => $request->get('moths', 1),
            'paypack_config' => $paypack->config(),
        ]);
    }

    public function pay(Request $request) : JsonResponse
    {
        $request->validate([
            'phone' => 'required|string',
            'months' => 'required|integer|min:1|max:12',
        ]);

        $months = $request->get('months');
        $amount = $months * 100;

        $paypack = new Paypack();
        $paypack->config([
            'client_id' => config('services.paypack.client_id'),
            'client_secret' => config('services.paypack.client_secret'),
        ]);

        // Step 1: Initiate cashin
        \Log::info('Initiating Paypack Cashin', [
            'phone' => $request->get('phone'),
            'amount' => $amount,
            'months' => $months,
        ]);
        $cashin = $paypack->Cashin([
            'phone' => $request->get('phone'),
            'amount' => $amount,
        ]);
        \Log::info('Paypack Cashin response', $cashin);
        // Step 2: Poll for transaction status using ref
        $ref = $cashin['ref'] ?? null;
        $transaction = null;
        if ($ref) {
            $transactions = $paypack->Transactions([
                'offset' => 0,
                'limit' => 100,
            ]);
            \Log::info('Paypack Transactions response', ['transactions' => $transactions, 'ref' => $ref]);
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
        $rawTimestamp = $transaction['timestamp'] ?? $cashin['created_at'] ?? null;
        if ($rawTimestamp) {
            try {
                $timestamp = \Carbon\Carbon::parse($rawTimestamp)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                $timestamp = now();
            }
        } else {
            $timestamp = now();
        }
        $paymentData = [
            'amount' => $transaction['amount'] ?? $cashin['amount'] ?? $amount,
            'client' => $transaction['client'] ?? $request->get('phone'),
            'kind' => $transaction['kind'] ?? $cashin['kind'] ?? 'cashin',
            'merchant' => $transaction['merchant'] ?? null,
            'ref' => $ref,
            'status' => $transaction['status'] ?? $cashin['status'] ?? 'pending',
            'timestamp' => $timestamp,
        ];
        $payment = Payment::create($paymentData);
        \Log::info('Payment record created', $payment->toArray());
        // Step 4: If payment is successful and amount is correct, update/create subscription
        if (($payment->amount == $months * 100) && ($payment->status === 'successful')) {
            $user = $payment->user;
            if ($user) {
                $start = now();
                $end = now()->addDays(31 * $months);
                $user->subscription()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'start_date' => $start,
                        'end_date' => $end,
                    ]
                );
                \Log::info('Subscription created/updated', [
                    'user_id' => $user->id,
                    'start_date' => $start,
                    'end_date' => $end,
                ]);
            }
        } else {
            \Log::info('Subscription not created. Payment not successful.', [
                'payment_status' => $payment->status,
                'payment_ref' => $payment->ref,
            ]);
        }

        return response()->json([
            'payment' => $payment,
            'transaction' => $transaction,
            'cashin' => $cashin,
            'payment_status' => $payment->status,
            'subscription_active' => $user ? ($user->subscription && now()->between($user->subscription->start_date, $user->subscription->end_date)) : false,
            'subscription_start' => $user && $user->subscription ? $user->subscription->start_date : null,
            'subscription_end' => $user && $user->subscription ? $user->subscription->end_date : null,
        ]);
    }

    public function status(Request $request) : JsonResponse
    {
        $paypack = new Paypack();
        $paypack->config([
            'client_id' => config('services.paypack.client_id'),
            'client_secret' => config('services.paypack.client_secret'),
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

    public function paymentLogs(Request $request) : JsonResponse
    {
        $payments = Payment::orderBy('created_at', 'desc')->paginate(5);
        $logs = $payments->map(function ($payment) {
            return [
                'ref' => $payment->ref,
                'timestamp' => $payment->timestamp,
                'phone' => $payment->client,
                'amount' => $payment->amount,
                'status' => $payment->status,
            ];
        });
        return response()->json($logs);
    }
}
