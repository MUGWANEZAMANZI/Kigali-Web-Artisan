<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Subscription;
use App\Models\User;
use App\Services\GreetingService;
use Illuminate\Support\Facades\Validator;
use App\Models\UserPrompt;

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
                return response()->json(['message' => 'Ntafatabuguzi ufite cg ryarangiye'], 403);
            }

            return $this->index($request);
        } else {
            // Unauthenticated: limit by IP
            $userIp = $request->ip();
            $date = now()->toDateString();
            $key = "prompts_{$userIp}_{$date}";
            $count = cache()->get($key, 0);

            if ($count >= 10) {
                return response()->json(['message' => 'amabaza y\'ubuntu yashize, uzagaruke ejo'], 429);
            }

            cache()->put($key, $count + 1, now()->addDay()->startOfDay());
            return $this->index($request);
        }
    }

    public function index(Request $request): JsonResponse
    {
        \Log::info('User prompt received', ['prompt' => $request->input('prompt')]);
        $validator = Validator::make($request->all(), [
            'prompt' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $prompt = $request->input('prompt');
        $prediction = $this->greetingService->predict($prompt);

        return response()->json([
            'prompt' => $prompt,
            'response' => $prediction
        ]);
    }

    /**
     * Store a new prompt and response for the authenticated user.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'prompt' => 'required|string|max:255',
            'response' => 'required|string',
        ]);

        \Log::info('storing prompts', ['user_id' => $user->id, 'prompt' => $request->input('prompt')]);

        // Determine subscription type
        $subscription = $user->subscription;
        $now = now();
        $subscriptionType = (!$subscription || $now->lt($subscription->start_date) || $now->gt($subscription->end_date)) ? 'free' : 'subscribed';

        // Store the prompt and response
        $userPrompt = UserPrompt::create([
            'user_id' => $user->id,
            'prompt' => $request->input('prompt'),
            'response' => $request->input('response'),
            'subscription_type' => $subscriptionType,
        ]);

        return response()->json([
            'message' => 'Prompt stored',
            'data' => $userPrompt,
        ], 201);
    }

    public function allPrompts(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $prompts = UserPrompt::where('user_id', $user->id)->get();

        return response()->json([
            'prompts' => $prompts,
        ]);
    }


}
