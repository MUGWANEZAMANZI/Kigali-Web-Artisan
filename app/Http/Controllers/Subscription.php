<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Models\Subscription as SubscriptionModel;
use App\Models\Payment;
use Carbon\Carbon;

class Subscription extends Controller
{
    public function Subscribe(Request $request) : JsonResponse
    {
        try {
            $request->validate([
                "client" => "required|string",
                "amount" => "required|numeric|min:1",
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user = User::where('phone', $request->input('client'))->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Store payment
        $payment = Payment::create([
            'amount' => $request->input('amount'),
            'client' => $user->phone,
            'kind' => 'cash',
            'merchant' => null,
            'ref' => null,
            'status' => 'success',
            'timestamp' => now(),
        ]);

        // If payment is 100 and successful, create or update subscription
        if ($payment->amount == 100 && $payment->status === 'success') {
            $start = Carbon::now();
            $end = Carbon::now()->addDays(31);
            SubscriptionModel::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'start_date' => $start,
                    'end_date' => $end,
                ]
            );
        }

        return response()->json([
            'message' => 'Payment processed',
            'payment_status' => $payment->status,
            'amount' => $payment->amount,
            'subscription_active' => $user->subscription ? true : false,
            'subscription_start' => $user->subscription->start_date ?? null,
            'subscription_end' => $user->subscription->end_date ?? null,
        ], 200);
    }
}
