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
            <div class="w-full flex justify-between items-center">
                <a wire:navigate href="{{route('register')}}" class="link link-primary">I want to create an account</a>
                <x-button label="Login" class="btn-primary" type="submit" spinner="login"/>
            </div>
        </x-slot:actions>


    </x-form>
</x-card>
