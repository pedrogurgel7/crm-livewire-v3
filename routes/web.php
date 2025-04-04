<?php

use Livewire\Volt\Volt;

//Volt::route('/', 'users.index');

Route::get('/', \App\Livewire\Welcome::class);

Route::get('register', \App\Livewire\Auth\Register::class)->name('auth.register');
Route::get('/logout', fn () => auth()->logout());
