<?php

use App\Livewire\Auth\{Login, Register};
use Livewire\Volt\Volt;

//Volt::route('/', 'users.index');

Route::get('/', \App\Livewire\Welcome::class)->name('dashboard');

Route::get('register', Register::class)->name('auth.register');
Route::get('login', Login::class)->name('auth.login');
Route::get('/logout', fn () => auth()->logout());
