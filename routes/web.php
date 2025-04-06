<?php

use App\Livewire\Auth\{Login, Register};
use App\Livewire\Welcome;

//Volt::route('/', 'users.index');

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
Route::get('/logout', function () {
    auth()->logout();

    return redirect()->route('login');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', Welcome::class)->name('dashboard');

});
