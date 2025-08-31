<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Team;
use App\Livewire\Mbazaai;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/teams', Team::class);


Route::get('/mbaza-ai', Mbazaai::class);

Route::get('/dorm-link-terms', function () {
    return view('dorm-link-terms');
});

Route::get('/mbazaai-terms', function () {
    return view('mbazaai-terms');
});

Route::get('reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware(['guest'])->name('password.reset');

Route::get('/careers', function () {
    return view('careers');
});
