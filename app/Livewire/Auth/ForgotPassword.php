<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ForgotPassword extends Component
{
    #[Rule(['required', 'string', 'email', 'max:255'])]
    public string $email = '';

    public $message = '';
    public function render(): View
    {
        return view('livewire.auth.forgot-password')->layout('components.layouts.guest');
    }

    public function sendResetLink()
    {
        $this->validate();
        $status = Password::sendResetLink(
            ['email' => $this->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->message = __($status); // Define a mensagem de sucesso
        } else {
            $this->addError('email', __($status)); // Adiciona erro para exibição
        }

    }
}
