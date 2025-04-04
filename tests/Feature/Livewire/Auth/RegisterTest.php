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
