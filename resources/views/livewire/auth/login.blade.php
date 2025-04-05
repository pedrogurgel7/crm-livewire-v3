<x-card title="Login" class="w-full max-w-sm mx-auto mt-11">

    @if($errors->hasAny(['invalidCredentials', 'rateLimiter']))
        <x-alert icon="o-exclamation-triangle" class="alert-warning mb-4">
            @if(!$errors->has('rateLimiter'))
                @error('invalidCredentials')
                <span>{{ $message }}</span>
                @enderror
            @endif
            @error('rateLimiter')
            <span>{{ $message }}</span>
            @enderror
        </x-alert>
    @endif

    <x-form wire:submit="login">
        <x-input label="Email" wire:model="email"/>
        <x-input label="Password" wire:model="password" type="password"/>

        <x-slot:actions>
            <x-button label="Reset"/>
            <x-button label="Register" class="btn-primary" type="submit" spinner="login"/>
        </x-slot:actions>
    </x-form>
</x-card>
