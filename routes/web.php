<?php

use App\Livewire\Auth\{Login, Register};
use App\Livewire\Welcome;

//Volt::route('/', 'users.index');

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
Route::get('/logout', fn () => auth()->logout());

Route::middleware(['auth'])->group(function () {
    Route::get('/', Welcome::class)->name('dashboard');

});
