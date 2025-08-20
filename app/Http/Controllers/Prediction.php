<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Subscription;
use App\Models\User;
use App\Services\GreetingService;
use Illuminate\Support\Facades\Validator;

class Prediction extends Controller
{
    private GreetingService $greetingService;

    public function __construct(GreetingService $greetingService)
    {
        $this->greetingService = $greetingService;
    }


    public function Authenticated(Request $request): JsonResponse
    {
        $user = auth()->user();
        if ($user) {
            $subscription = $user->subscription;
            // Authenticated users are not limited by IP
            if (!$subscription || now()->lt($subscription->start_date) || now()->gt($subscription->end_date)) {
                return response()->json(['message' => 'Subscription expired or not found'], 403);
            }

            return $this->index($request);
        } else {
            // Unauthenticated: limit by IP
            $userIp = $request->ip();
            $date = now()->toDateString();
            $key = "prompts_{$userIp}_{$date}";
            $count = cache()->get($key, 0);

            if ($count >= 10) {
                return response()->json(['message' => 'Prompt limit reached for today'], 429);
            }

            cache()->put($key, $count + 1, now()->addDay()->startOfDay());
            return $this->index($request);
        }
    }

    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'greeting' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $greeting = $request->input('greeting');
        $prediction = $this->greetingService->predict($greeting);

        return response()->json([
            'greeting' => $greeting,
            'response' => $prediction
        ]);
    }
}
