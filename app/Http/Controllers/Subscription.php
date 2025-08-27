<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Models\Subscription as SubscriptionModel;
use App\Models\Payment;
use Carbon\Carbon;
use Paypack\Paypack;

class Subscription extends Controller
{
    public function Subscribe(Request $request) : JsonResponse
    {
        try {
            $request->validate([
                "phone" => "required|string",
                "months" => "required|integer|min:1|max:12",
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $months = $request->input('months');
        $amount = $months * 100;

        $user = User::where('phone', $request->input('phone'))->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Initiate Paypack Cashin
        \Log::info('Initiating Paypack Cashin', [
            'phone' => $user->phone,
            'amount' => $amount,
            'months' => $months,
        ]);
        $paypack = new Paypack();
        $paypack->config([
            'client_id' => config('services.paypack.client_id'),
            'client_secret' => config('services.paypack.client_secret'),
        ]);
        $cashin = $paypack->Cashin([
            'phone' => $user->phone,
            'amount' => $amount,
        ]);
        \Log::info('Paypack Cashin response', $cashin);
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
        // Parse and format timestamp for MySQL
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
        // Store payment with real status and details
        $payment = Payment::create([
            'amount' => $transaction['amount'] ?? $cashin['amount'] ?? $amount,
            'client' => $transaction['client'] ?? $user->phone,
            'kind' => $transaction['kind'] ?? $cashin['kind'] ?? 'cashin',
            'merchant' => $transaction['merchant'] ?? '',
            'ref' => $ref ?? '',
            'status' => $transaction['status'] ?? $cashin['status'] ?? 'pending',
            'timestamp' => $timestamp,
        ]);
        \Log::info('Payment record created', $payment->toArray());
        // Only create subscription if payment is correct and status is successful
        if ($payment->amount == $months * 100 && $payment->status === 'successful') {
            $start = Carbon::now();
            $end = Carbon::now()->addDays(31 * $months);
            SubscriptionModel::updateOrCreate(
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
        } else {
            \Log::info('Subscription not created. Payment not successful.', [
                'payment_status' => $payment->status,
                'payment_ref' => $payment->ref,
            ]);
        }

        return response()->json([
            'message' => 'Payment processed',
            'payment_status' => $payment->status,
            'amount' => $payment->amount,
            'subscription_active' => $user->subscription ? true : false,
            'subscription_start' => $user->subscription->start_date ?? null,
            'subscription_end' => $user->subscription->end_date ?? null,
            'transaction' => $transaction,
            'cashin' => $cashin,
        ], 200);
    }
}
