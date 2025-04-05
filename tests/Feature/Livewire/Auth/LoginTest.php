<?php

use App\Livewire\Auth\Login;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Login::class)
        ->assertStatus(200);
});

it('should be able to login a user', function () {

    $user = \App\Models\User::query()->create([
        'name'     => 'John dee',
        'email'    => 'contato@gmail.com',
        'password' => bcrypt('password'),
    ]);

    Livewire::test(Login::class)
        ->set('email', 'contato@gmail.com')
        ->set('password', 'password')
        ->call('login')
        ->assertHasNoErrors()->assertRedirect(route('dashboard'));

    expect(auth()->check())->and(auth()->user()->id)->toBe($user->id);

});
it('should show an error if the credentials are invalid', function () {
    Livewire::test(Login::class)
        ->set('email', 'contato@gmail.com')
        ->set('password', 'password')
        ->call('login')
        ->assertHasNoErrors(['invalid_credentials']);
});
