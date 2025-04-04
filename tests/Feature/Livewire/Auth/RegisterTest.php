<?php
use App\Livewire\Auth\Register;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
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

        ->assertHasNoErrors()->assertRedirect('/');

    \Pest\Laravel\assertDatabaseHas('users', [
        'name' => 'John dee',
    ]);

    \Pest\Laravel\assertDatabaseCount('users', 1);

    expect(auth()->check())->and(auth()->user()->id)->toBe(User::first()->id);

});

test('validation rules', function ($f) {
    Livewire::test(Register::class)
        ->set($f->field, $f->value)
        ->call('submit')
        ->assertHasErrors([$f->field => $f->rule]);

})->with([
    'name::required'     => (object) ['field' => 'name', 'value' => '', 'rule' => 'required'],
    'name::max:255'      => (object) ['field' => 'name', 'value' => str_repeat('*', 256), 'rule' => 'max'],
    'email::required'    => (object) ['field' => 'email', 'value' => '', 'rule' => 'required'],
    'email::email'       => (object) ['field' => 'email', 'value' => 'not-an-email', 'rule' => 'email'],
    'email::confirmed'   => (object) ['field' => 'email', 'value' => 'jo3@gmail.com', 'rule' => 'confirmed'],
    'password::required' => (object) ['field' => 'password', 'value' => '', 'rule' => 'required'],

]);

it('should be able to send a welcome notification for the new user', function () {
    Notification::fake();

    Livewire::test(Register::class)
        ->set('name', 'John dee')
        ->set('email', 'contato@gmail.com')
        ->set('email_confirmation', 'contato@gmail.com')
        ->set('password', 'password')->call('submit');

    $user = User::whereEmail('contato@gmail.com')->first();

    Notification::assertSentTo($user, \App\Notifications\WelcomeNotification::class);

});
