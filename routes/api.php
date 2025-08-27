<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Prediction;
use App\Http\Controllers\Authenthication;
use App\Http\Controllers\Subscription;




Route::post('/prompts', [Prediction::class, 'Authenticated'])
    ->name('prompts.authenticated');

Route::post('/login', [Authenthication::class, 'login'])->name('auth.login');
Route::post('/register', [Authenthication::class, 'Register'])->name('auth.register');
Route::post('/profile', [Authenthication::class, 'Profile'])->name('auth.profile');
Route::post('/logout', [Authenthication::class, 'Logout'])->name('auth.logout');
Route::post('/forgot-password', [Authenthication::class, 'ForgotPassword'])->name('auth.forgot-password');

Route::post('/subscribe', [Subscription::class, 'Subscribe'])->name('subscribe');

