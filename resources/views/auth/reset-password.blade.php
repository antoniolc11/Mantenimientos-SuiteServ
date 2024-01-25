<x-guest-layout>
    <form id="resetForm" method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <table>
                <tbody>
                    <tr>
                        <td class="break-words border-collapse" style="vertical-align: top;">
                            <div class="mx-auto min-w-min max-w-screen-md break-words bg-gray-400">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td class="p-0 text-center h-full flex items-center justify-center">
                                            {{-- Logo empresa --}}
                                            <img src="{{ asset('imagenes/logo.png') }}" alt="Logo SuiteServ"
                                                title="Image"
                                                class="outline-none text-decoration-none block border-none max-w-10 h-auto w-40 mt-6 mb-6"
                                                width="58" />
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="mx-auto min-w-min max-w-screen-md break-words bg-white">
                                <table class="font-sans" role="presentation" cellpadding="0" cellspacing="0"
                                    width="100%" border="0">
                                    <tbody>
                                        <tr>
                                            <td class="p-10 text-left">
                                                <div class="text-base leading-6">

                                                    <p class="mb-6">
                                                        <span class="font-bold">¡Bienvenido! </span>Parece que es la
                                                        primera vez que inicias sesión en
                                                        nuestra plataforma. Para garantizar la seguridad de tu cuenta,
                                                        necesitamos que establezcas una contraseña ahora.

                                                        Por favor, introduce tu dirección de correo electrónico y elige
                                                        una contraseña segura para tu cuenta.


                                                    </p>
                                                    <p>
                                                        Saludos,
                                                        Mantenimientos-SuiteServ.
                                                    </p>
                                                </div>

                                                <div class="mt-10">
                                                    <form method="POST" action="{{ route('password.email') }}">
                                                        @csrf

                                                        <!-- Email Address -->
                                                        <div>
                                                            <x-input-label for="email" :value="__('Email')" />
                                                            <x-text-input id="email" class="block mt-1 w-full"
                                                                type="text" name="email" :value="old('email', $request->email)"
                                                                autofocus autocomplete="username" readonly />
                                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                        </div>

                                                        <!-- Password -->
                                                        <div class="mt-4">
                                                            <x-input-label for="password" :value="__('Password')" />
                                                            <x-text-input id="password" class="block mt-1 w-full"
                                                                type="password" name="password"
                                                                autocomplete="new-password" />
                                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                            <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="passwordError"></div>

                                                        </div>

                                                        <!-- Confirm Password -->
                                                        <div class="mt-4">
                                                            <x-input-label for="password_confirmation"
                                                                :value="__('Confirm Password')" />

                                                            <x-text-input id="password_confirmation"
                                                                class="block mt-1 w-full" type="password"
                                                                name="password_confirmation"
                                                                autocomplete="new-password" />

                                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                                                <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="passwordConfirm"></div>

                                                        </div>

                                                        <div class="flex flex-col items-center mt-8">
                                                            <x-primary-button>
                                                                {{ __('Enviar') }}
                                                            </x-primary-button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
        {{-- Validación de campos con js --}}
        <script src="{{ asset('js/validation_passwordReset.js') }}"></script>
</x-guest-layout>
