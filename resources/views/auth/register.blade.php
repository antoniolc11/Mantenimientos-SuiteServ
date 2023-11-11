<x-app-layout>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <!-- Nombre -->
        <div>
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required
                autofocus autocomplete="nombre" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Primer apellido -->
        <div class="mt-4">
            <x-input-label for="primer_apellido" :value="__('Primer apellido')" />
            <x-text-input id="primer_apellido" class="block mt-1 w-full" type="text" name="primer_apellido"
                :value="old('primer_apellido')" required autofocus autocomplete="primer_apellido" />
            <x-input-error :messages="$errors->get('primer_apellido')" class="mt-2" />
        </div>

        <!-- segundo apellido -->
        <div class="mt-4">
            <x-input-label for="segundo_apellido" :value="__('Segundo apellido')" />
            <x-text-input id="segundo_apellido" class="block mt-1 w-full" type="text" name="segundo_apellido"
                :value="old('segundo_apellido')" required autofocus autocomplete="segundo_apellido" />
            <x-input-error :messages="$errors->get('segundo_apellido')" class="mt-2" />
        </div>

        <!-- nif -->
        <div class="mt-4">
            <x-input-label for="nif" :value="__('Nif')" />
            <x-text-input id="nif" class="block mt-1 w-full" type="text" name="nif" :value="old('nif')"
                required autofocus autocomplete="nif" />
            <x-input-error :messages="$errors->get('nif')" class="mt-2" />
        </div>

        <!-- telefono -->
        <div class="mt-4">
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')"
                required autofocus autocomplete="telefono" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Departamento -->
        <div class="mt-4">
            <label for="departamento">Departamento:</label>
            <select name="departamento" id="departamento" class="block mt-1 w-full">
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('departamento')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
