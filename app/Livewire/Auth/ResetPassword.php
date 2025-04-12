<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\{Hash, Password};
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ResetPassword extends Component
{
    public ?string $token;

    #[Rule(['required', 'string', 'min:8', 'confirmed'])]
    public ?string $email;

    #[Rule(['required', 'string', 'min:8', 'same:email'])]
    public ?string $email_confirmation;

    public ?string $password;

    public ?string $password_confirmation;

    public function mount($token)
    {
        $this->email = request()->get('email');
        $this->token = $token;

    }
    public function render()
    {
        return view('livewire.auth.reset-password')->layout('components.layouts.guest');
    }

    public function submit()
    {
        $this->validate();

        $status = Password::reset(
            ['email' => $this->email, 'password' => $this->password, 'password_confirmation' => $this->password_confirmation, 'token' => $this->token],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
                auth()->login($user);
            }
        );

        if ($status === Password::PasswordReset) {
            redirect()->route('dashboard')->with('status', __($status));
        } else {
            back()->withErrors(['email' => [__($status)]]);
        }

    }

    public function obfuscatedEmail(): String
    {
        return obfuscate_email($this->email);
    }
}
