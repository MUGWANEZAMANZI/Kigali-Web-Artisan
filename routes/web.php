<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Team;
use App\Livewire\Mbazaai;
use App\Http\Controllers\PasswordUpdateController;

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

Route::get('/reset-password/{token}', [PasswordUpdateController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordUpdateController::class, 'update'])->name('password.update');

Route::get('/careers', function () {
    return view('careers');
});
