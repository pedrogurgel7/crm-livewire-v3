<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Register extends Component
{
    #[Rule(['required', 'string', 'max:255'])]
    public ?string $name = '';

    #[Rule(['required', 'string', 'email', 'max:255', 'unique:users', 'confirmed'])]
    public ?string $email = '';

    #[Rule(['required', 'string', 'same:email'])]
    public ?string $email_confirmation = '';

    #[Rule(['required', 'string', 'min:8'])]
    public ?string $password = '';

    public function render(): View
    {
        return view('livewire.auth.register');
    }

    public function submit(): void
    {
        $this->validate();

        User::query()->create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ]);
    }
}
