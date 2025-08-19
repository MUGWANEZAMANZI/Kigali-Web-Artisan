<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Prediction;




Route::post('/prompts', [Prediction::class, 'Authenticated'])
    ->name('prompts.authenticated');

