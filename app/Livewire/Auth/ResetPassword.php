<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\{Hash, Password};
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component
{
    public ?string $token;

    public ?string $email;

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
}
