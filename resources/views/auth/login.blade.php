<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div x-data="{ showMessage: true }" x-init="setTimeout(() => showMessage = false, 10000)">
        <div class="alert alert-success" x-show="showMessage" x-cloak>
            {{ session('success') }}
        </div>
    </div>

    <div class="w-full flex flex-wrap">

        <!-- Login Section -->
        <div class="w-full md:w-1/2 flex flex-col">

            <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-24">
                <img src="{{ asset('imagenes/logo.png') }}" alt="Mi Logo" class="w-40 h-auto">
            </div>

            <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
                <p class="text-center text-3xl">Bienvenido.</p>
                <form class="flex flex-col pt-3 md:pt-8" method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email Address -->
                    <div class="flex flex-col pt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')"
                            placeholder="tu@email.com" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="flex flex-col pt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input type="password" id="password" placeholder="Contraseña" name="password" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Recuérdame-->
                    <div class="flex flex-col pt-4">
                        <label for="remember_me" class="text-lg">
                            <input id="remember_me" type="checkbox"
                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800 "
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recuérdame') }}</span>
                        </label>
                    </div>

                    <x-primary-button class="bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8">
                        {{ __('Acceso') }}
                    </x-primary-button>
                </form>

                <div class="text-center pt-12 pb-6">
                    @if (Route::has('password.request'))
                        <a class="underline font-semibold  text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                            href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif

                </div>

                <div class="text-center">
                    <a class="underline font-semibold  text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('aspirantes.create') }}">¿Quieres trabajar con nosotros?</a>
                </div>
            </div>

        </div>

        <!-- Image Section -->
        <div class="w-1/2 shadow-2xl">
            <img class="object-cover w-full h-screen hidden md:block" src="https://source.unsplash.com/IXUM4cJynP0">
        </div>
    </div>
</x-guest-layout>
