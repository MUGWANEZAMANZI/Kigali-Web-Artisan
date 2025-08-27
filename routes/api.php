<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Prediction;
use App\Http\Controllers\Authenthication;
use App\Http\Controllers\Subscription;
use App\Http\Controllers\PaymentController;




Route::post('/prompts', [Prediction::class, 'Authenticated'])
    ->name('prompts.authenticated');

Route::post('/login', [Authenthication::class, 'login'])->name('auth.login');
Route::post('/register', [Authenthication::class, 'Register'])->name('auth.register');
//Route::post('/profile', [Authenthication::class, 'Profile'])->name('auth.profile');
//Route::post('/logout', [Authenthication::class, 'Logout'])->name('auth.logout');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile', [Authenthication::class, 'profile'])->name('auth.profile');
    Route::post('/logout', [Authenthication::class, 'logout'])->name('auth.logout');
    Route::post('/subscribe', [Subscription::class, 'Subscribe'])->name('subscribe');
    Route::post('/payments-logs', [PaymentController::class, 'paymentLogs'])->name('payments.logs');
    // In routes/api.php
    Route::post('/prompts/store', [Prediction::class, 'store'])->name('prompts.store');
    Route::post('/all-prompts', [Prediction::class, 'allPrompts'])->name('prompts.all');
});
Route::post('/forgot-password', [Authenthication::class, 'ForgotPassword'])->name('auth.forgot-password');

Route::post('/subscribe', [Subscription::class, 'Subscribe'])->name('subscribe');

