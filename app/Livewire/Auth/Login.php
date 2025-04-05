<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    #[Rule(['required', 'string', 'email', 'max:255'])]
    public string $email = '';

    #[Rule(['required', 'string', 'min:8'])]
    public string $password = '';
    public function render(): View
    {
        return view('livewire.auth.login')->layout('components.layouts.guest');
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt($this->only('email', 'password'))) {
            $this->redirect('/');
        } else {
            $this->addError('invalidCredentials', trans('auth.failed'));
        }

    }
}
