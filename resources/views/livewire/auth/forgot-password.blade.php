<x-card title="Password Recovery" class="w-full max-w-sm mx-auto mt-11">
    @error('email')
    {{ $message }}
    @enderror

    @if("$message")
        <x-alert icon="o-check" class="alert-success mb-4">
            {{$message}}
        </x-alert>
    @endif


    <x-form wire:submit="sendResetLink">


        <x-input label="Email" wire:model="email"/>

        <x-slot:actions>


            <x-button label="Send Code" class="btn-primary" type="submit" spinner="sendResetLink"/>


        </x-slot:actions>
    </x-form>
</x-card>
