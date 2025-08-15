<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Team;
use App\Livewire\Mbazaai;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/teams', Team::class);


Route::get('/mbaza-ai', Mbazaai::class);
