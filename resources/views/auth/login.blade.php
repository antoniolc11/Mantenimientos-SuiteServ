<x-guest-layout>
    <div x-data="{ showMessage: true }" x-init="setTimeout(() => showMessage = false, 5000)" class="w-full">
        <div x-show="showMessage" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100 h-auto"
            x-transition:leave-end="opacity-0 transform scale-90 h-0" class="alert alert-success">

            <!-- Mostrar mensajes de sesión usando el componente x-auth-session-status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <x-auth-session-status class="mb-4" :status="session('success')" />
        </div>
    </div>

    <div class="w-full flex flex-wrap">
        <!-- Login Section -->
        <div class="w-full md:w-1/2 flex flex-col">

            <div class="flex items-center justify-center md:justify-start  md:mt-16">
                <div class="mx-auto">
                    <img src="{{ asset('imagenes/logo.png') }}" alt="Mi Logo" class="w-40 h-auto">
                </div>
            </div>

            <div class="flex flex-col justify-center md:justify-start mt-14 pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
                <p class="text-center text-3xl">Bienvenido.</p>
                <form id="loginForm" class="flex flex-col pt-3 md:pt-8" method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email Address -->
                    <x-input-error :messages="session('error')" class="" />
                    <div class="flex flex-col pt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="emailvalue" type="text" name="email" :value="old('email')"
                            placeholder="tu@email.com" autofocus autocomplete="username" />
                        <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="emailError"></div>

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="flex flex-col pt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input type="password" id="passwordvalue" placeholder="Contraseña" name="password"
                            autocomplete="current-password" />

                        <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="passwordError"></div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    </div>

                    <!-- Recuérdame-->
                    <div class="flex flex-col pt-4">
                        <label for="remember_me" class="text-lg">
                            <input id="remember_me" type="checkbox"
                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-black shadow-sm focus:ring-black dark:focus:ring-black dark:focus:ring-offset-gray-800 "
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recuérdame') }}</span>
                        </label>
                    </div>
                    <x-primary-button class="bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8">
                        {{ __('Acceso') }}
                    </x-primary-button>
                </form>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Se obtienen referencias a los campos de correo electrónico y contraseña
                        var emailInput = document.getElementById('emailvalue');
                        var passwordInput = document.getElementById('passwordvalue');

                        // Se agrega un event listener al formulario para el evento de envío
                        document.getElementById('loginForm').addEventListener('submit', function(event) {
                            // Si la validación del formulario no pasa, se evita que se envíe el formulario
                            if (!validateLoginForm()) {
                                event.preventDefault();
                            }
                        });

                        // Función que realiza la validación del formulario
                        function validateLoginForm() {
                            var email = emailInput.value;
                            var password = passwordInput.value;

                            clearErrorMessages();

                            var errors = [];

                            // Se llama a la función de validación para el correo electrónico
                            validateEmail(email, errors);

                            // Se llama a la función de validación para la contraseña
                            validatePassword(password, errors);

                            // Se muestran los mensajes de error, si los hay
                            displayErrors(errors);

                            // El formulario es válido si no hay errores
                            return errors.length === 0;
                        }

                        // Función que valida el campo de correo electrónico
                        function validateEmail(email, errors) {
                            if (email.trim() === '') {
                                errors.push('Por favor, ingresa tu correo electrónico.');
                            } else {
                                // Expresión regular para validar el formato del correo electrónico
                                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                                if (!emailRegex.test(email)) {
                                    errors.push('Por favor, ingresa un correo electrónico válido.');
                                }
                            }
                        }

                        // Función que valida el campo de contraseña
                        function validatePassword(password, errors) {
                            if (password.trim() === '') {
                                errors.push('Por favor, ingresa tu contraseña.');
                            }
                        }

                        // Función que muestra los mensajes de error en los contenedores correspondientes
                        function displayErrors(errors) {
                            for (var i = 0; i < errors.length; i++) {
                                var errorContainerId = 'emailError'; // Contenedor predeterminado

                                // Se verifica si el mensaje de error incluye la palabra "contraseña"
                                if (errors[i].toLowerCase().includes('contraseña')) {
                                    errorContainerId = 'passwordError';
                                }

                                // Se verifica si el mensaje de error incluye la palabra "email"
                                if (errors[i].toLowerCase().includes('email')) {
                                    errorContainerId = 'emailError';
                                }

                                // Se obtiene el contenedor de error correspondiente y se crea un elemento de párrafo con el mensaje de error
                                var errorContainer = document.getElementById(errorContainerId);
                                var errorMessage = document.createElement('p');
                                errorMessage.textContent = errors[i];
                                errorContainer.appendChild(errorMessage);
                            }
                        }

                        // Función para limpiar los mensajes de error existentes en los contenedores
                        function clearErrorMessages() {
                            document.getElementById('emailError').textContent = '';
                            document.getElementById('passwordError').textContent = '';
                        }
                    });
                </script>

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
