<?php

use App\Livewire\Auth\{ForgotPassword, Login, Register, ResetPassword};
use App\Livewire\Welcome;

//Volt::route('/', 'users.index');

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
Route::get('forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');

Route::middleware(['auth'])->group(function () {
    Route::get('/', Welcome::class)->name('dashboard');

});
