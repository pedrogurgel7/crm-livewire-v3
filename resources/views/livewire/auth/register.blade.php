<x-card title="Register" class="w-full max-w-sm mx-auto mt-11">

    <x-form wire:submit="submit">
        <x-input label="Name" wire:model="name"/>
        <x-input label="Email" wire:model="email"/>
        <x-input label="Confirm Email" wire:model="email_confirmation"/>
        <x-input label="Password" wire:model="password" type="password"/>

        <x-slot:actions>

            <div class="w-full flex justify-between items-center">
                <a wire:navigate href="{{route('login')}}" class="link link-primary">I Already have an account</a>
                <x-button label="Register" class="btn-primary" type="submit" spinner="submit"/>
            </div>

        </x-slot:actions>
    </x-form>
</x-card>
