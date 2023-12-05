<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="h-9">
                {{-- Mostrar los mensajes de exito. --}}
                @if (session('success'))
                    <x-success-alert :status="session('success')" />
                    <?php session()->forget('success'); ?>
                @endif

                {{-- Mostrar los mensajes de error. --}}
                @if (session('error'))
                    <x-error-alert :messages="session('error')" />
                @endif
            </div>
            @if (auth()->user()->esDepartamentoDireccion())
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
