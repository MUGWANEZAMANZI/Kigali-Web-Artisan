<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class Authenthication extends Controller
{
    public function Register(Request $request): JsonResponse
    {
        try {


            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
                'phone' => 'required|string|max:15|unique:users',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        if ($validatedData['password'] !== $request->input('password_confirmation')) {
            return response()->json(['message' => 'Password confirmation does not match'], 422);
        }

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'phone' => $validatedData['phone'],
        ]);

        if (!$user) {
            return response()->json(['message' => 'User registration failed'], 500);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);

    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'phone', 'password']);

        if (isset($credentials['email'])) {
            $loginField = 'email';
            $loginValue = $credentials['email'];
        } elseif (isset($credentials['phone'])) {
            $loginField = 'phone';
            $loginValue = $credentials['phone'];
        } else {
            return response()->json(['message' => 'Email or phone is required'], 422);
        }

        if (!auth()->attempt([$loginField => $loginValue, 'password' => $credentials['password']])) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = User::where($loginField, $loginValue)->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        $subscription = $user->subscription;
        $now = now();
        if (!$subscription || $now->lt($subscription->start_date) || $now->gt($subscription->end_date)) {
            return response()->json([
                'user' => $user,
                'subscription' => 'No active subscription',
            ]);
        }
        return response()->json([
            'user' => $user,
            'subscription' => [
                'start_date' => $subscription->start_date,
                'end_date' => $subscription->end_date,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user) {
            $user->currentAccessToken()?->delete();
        }
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        \Log::info(["message" => $status]);

        return response()->json(['message' => 'Niba imeli yawe yanditse urahabwa linki yo guhindura Ijambobanga ryawe']);
    }
}
