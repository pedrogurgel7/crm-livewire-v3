<div>
    <x-card title="Change your password" class="w-full max-w-sm mx-auto mt-11">


        <x-form wire:submit="submit">

            <x-input label="Email" disabled value="{{$this->obfuscatedEmail()}}"/>
            <x-input label="Email Confirmation" wire:model="email_confirmation"/>
            <x-input label="Password" wire:model="password" type="password"/>
            <x-input label="Password Confirmation" wire:model="password_confirmation" type="password"/>

            <x-slot:actions>

                <x-button label="Change Password" class="btn-primary" type="submit" spinner="submit"/>


            </x-slot:actions>
        </x-form>
    </x-card>
</div>
