<?php
use Illuminate\Support\Facades\Route;




Route::get('/prompts', function () {
    return response()->json(['message' => 'Welcome to the API!']);
});
