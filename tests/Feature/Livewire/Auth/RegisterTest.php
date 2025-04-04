<?php

use App\Livewire\Auth\Register;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Register::class)
        ->assertStatus(200);

});

it('should be able to register a user', function () {
    Livewire::test(Register::class)
        ->set('name', 'John dee')
        ->set('email', 'contato@gmail.com')
        ->set('email_confirmation', 'contato@gmail.com')
        ->set('password', 'password')->call('submit')

        ->assertHasNoErrors();

    \Pest\Laravel\assertDatabaseHas('users', [
        'name' => 'John dee',
    ]);

    \Pest\Laravel\assertDatabaseCount('users', 1);
});
