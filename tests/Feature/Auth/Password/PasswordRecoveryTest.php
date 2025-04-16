<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas, get};

test('needs to have a route to password recovery', function () {
    get(route('forgot-password'))
        ->assertSeeLivewire('auth.forgot-password');
});

it('should be able to request for a password recovery sending notification to the user', function () {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    Livewire::test(\App\Livewire\Auth\ForgotPassword::class)
        ->set('email', $user->email)
        ->call('sendResetLink')
        ->assertSee('We have emailed your password reset link.');

    Notification::assertSentTo(
        $user,
        ResetPassword::class
    );
});

test('testing email property', function ($value, $rule) {
    Livewire::test(\App\Livewire\Auth\ForgotPassword::class)
        ->set('email', $value)
        ->call('sendResetLink')
        ->assertHasErrors(['email' => $rule]);
})->with([
    'required' => ['value' => '', 'rule' => 'required'],
    'email'    => ['value' => 'any email', 'rule' => 'email'],
]);

test('needs to create a token when requesting for a password recovery', function () {
    /** @var User $user */
    $user = User::factory()->create();

    Livewire::test(\App\Livewire\Auth\ForgotPassword::class)
        ->set('email', $user->email)
        ->call('sendResetLink');

    assertDatabaseCount('password_reset_tokens', 1);
    assertDatabaseHas('password_reset_tokens', ['email' => $user->email]);
});
