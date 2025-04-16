<?php

use App\Livewire\Auth\Login;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Login::class)
        ->assertStatus(200);
});

it('should be able to login a user', function () {

    $user = User::query()->create([
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
        ->assertHasErrors(['invalidCredentials']);
});

it('should make sure that rate limiting is blocking after 5 attempts', function () {
    $user = User::factory()->create();

    for ($i = 0; $i < 5; $i++) {
        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('login')->assertHasErrors(['invalidCredentials']);
    }

    Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('login')->assertHasErrors(['rateLimiter']);
});
