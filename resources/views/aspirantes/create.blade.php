<x-guest-layout>
    <div class="mt-5 mb-64">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <form id="aspiranteRegistro" method="POST" action="{{ route('aspirantes.store') }}" class="mt-6 ml-6 mr-6 "
                enctype="multipart/form-data">
                @csrf


                <h1 id="titulo" class="vagbold text-gray-700 text-5xl mb-16 font-bold font-montserrat">
                    Trabaja con nosotros
                </h1>

                <!-- Nombre -->
                <div>
                    <x-input-label for="nombre" :value="__('Nombre')" />
                    <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre"
                        placeholder="Escribe tu nombre" :value="old('nombre')" autofocus autocomplete="nombre" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="nombreError"></div>
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <!-- Primer apellido -->
                <div class="mt-4">
                    <x-input-label for="primer_apellido" :value="__('Primer apellido')" />
                    <x-text-input id="primer_apellido" class="block mt-1 w-full" type="text" name="primer_apellido"
                        placeholder="Escribe tu primer apellido" :value="old('primer_apellido')" autofocus
                        autocomplete="primer_apellido" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="ap1Error"></div>

                    <x-input-error :messages="$errors->get('primer_apellido')" class="mt-2" />
                </div>

                <!-- segundo apellido -->
                <div class="mt-4">
                    <x-input-label for="segundo_apellido" :value="__('Segundo apellido')" />
                    <x-text-input id="segundo_apellido" class="block mt-1 w-full" type="text" name="segundo_apellido"
                        placeholder="Escribe tu segundo apellido" :value="old('segundo_apellido')" autofocus
                        autocomplete="segundo_apellido" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="ap2Error"></div>
                    <x-input-error :messages="$errors->get('segundo_apellido')" class="mt-2" />
                </div>

                <!-- nif -->
                <div class="mt-4">
                    <x-input-label for="nif" :value="__('Nif')" />
                    <x-text-input id="nif" class="block mt-1 w-full" type="text" name="nif"
                        placeholder="47587412T" :value="old('nif')" autofocus autocomplete="nif" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="nifError"></div>
                    <x-input-error :messages="$errors->get('nif')" class="mt-2" />
                </div>

                <!-- telefono -->
                <div class="mt-4">
                    <x-input-label for="telefono" :value="__('Teléfono')" />
                    <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono"
                        placeholder="657841257" :value="old('telefono')" autofocus autocomplete="telefono" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="telefonoError"></div>

                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                        placeholder="tu@email.com" :value="old('email')" autocomplete="username" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="emailError"></div>

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>



                <div class="w-full relative h-32 flex flex-row items-center justify-center">
                    <a href="{{ route('login') }}" class="absolute left-6 py-2 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            class="w-10 h-10 mb-2 mt-auto hover:scale-110">
                            <path
                                d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160zm352-160l-160 160c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L301.3 256 438.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0z" />
                        </svg>
                    </a>


                    <div class="flex flex-col items-center">
                        <x-primary-button>
                            {{ __('Enviar') }}
                        </x-primary-button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @include('components.cookies')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Se obtienen referencias a los campos del formulario
            var nombreInput = document.getElementById('nombre');
            var primerApellidoInput = document.getElementById('primer_apellido');
            var segundoApellidoInput = document.getElementById('segundo_apellido');
            var nifInput = document.getElementById('nif');
            var telefonoInput = document.getElementById('telefono');
            var emailInput = document.getElementById('email');
            // Se agrega un event listener al formulario para el evento de envío
            document.getElementById('aspiranteRegistro').addEventListener('submit', function(event) {
                // Si la validación del formulario no pasa, se evita que se envíe el formulario
                if (!validateForm()) {
                    event.preventDefault();
                }
            });

            // Función que realiza la validación del formulario
            function validateForm() {
                var nombre = nombreInput.value;
                var primerApellido = primerApellidoInput.value;
                var segundoApellido = segundoApellidoInput.value;
                var nif = nifInput.value;
                var telefono = telefonoInput.value;
                var email = emailInput.value;

                // Se limpian los mensajes de error existentes
                clearErrorMessages();

                var errors = [];

                // Validación del campo "nombre"
                validateName(nombre, errors);

                // Validación del campo "primer_apellido"
                validateAp1(primerApellido, errors);

                // Validación del campo "nif"
                validateNif(nif, errors);

                // Validación del campo "telefono"
                validateTel(telefono, errors);

                // Validación del campo "email"
                validateEmail(email, errors);

                // Se muestran los mensajes de error, si los hay
                displayErrors(errors);

                // El formulario es válido si no hay errores
                return errors.length === 0;
            }


            // Función que valida el campo de nombre
            function validateName(nombre, errors) {
                if (nombre.trim() === '') {
                    errors.push('Por favor, ingresa tu nombre.');
                }
            }

            // Función que valida el campo de primer apellido
            function validateAp1(primerApellido, errors) {
                if (primerApellido.trim() === '') {
                    errors.push('Por favor, ingresa tu primer apellido.');
                }
            }

            // Función que valida el campo del nif
            function validateNif(nif, errors) {
                if (nif.trim() === '') {
                    errors.push('Por favor, ingresa tu nif.');
                } else {
                    // Expresión regular para validar el formato del nif en España (8 dígitos y una letra)
                    var dniRegex = /^[0-9]{8}[a-zA-Z]$/;

                    // Validar que el nif cumpla con el formato esperado
                    if (!dniRegex.test(nif)) {
                        errors.push('Por favor, ingresa un nif válido (8 dígitos seguidos de una letra).');
                    }
                    /*  else {
                                            // Validar la letra del nif
                                            var letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
                                            var letraDNI = nif.charAt(nif.length - 1).toUpperCase();
                                            var digitosDNI = parseInt(nif.substring(0, nif.length - 1), 10);

                                            if (letras.charAt(digitosDNI % 23) !== letraDNI) {
                                                errors.push('La letra del nif no es válida.');
                                            }
                                        } */
                }
            }

            // Función que valida el campo de número de teléfono
            function validateTel(telefono, errors) {
                if (telefono.trim() === '') {
                    errors.push('Por favor, ingresa tu número de teléfono.');
                } else {
                    // Expresión regular para validar que el teléfono contenga solo dígitos
                    var phoneRegex = /^\d+$/;

                    // Validar que el teléfono solo contenga dígitos y tenga al menos 9 caracteres
                    if (!phoneRegex.test(telefono) || telefono.length < 9) {
                        errors.push('Por favor, ingresa un número de teléfono válido (9 dígitos).');
                    }
                }
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

            // Función que muestra los mensajes de error en los contenedores correspondientes
            function displayErrors(errors) {
                for (var i = 0; i < errors.length; i++) {
                    var errorContainerId = 'emailError'; // Contenedor predeterminado

                    // Se verifica si el mensaje de error incluye la palabra "email"
                    if (errors[i].toLowerCase().includes('email')) {
                        errorContainerId = 'emailError';
                    }

                    if (errors[i].toLowerCase().includes('nombre')) {
                        errorContainerId = 'nombreError';
                    }

                    if (errors[i].toLowerCase().includes('primer apellido')) {
                        errorContainerId = 'ap1Error';
                    }

                    if (errors[i].toLowerCase().includes('nif')) {
                        errorContainerId = 'nifError';
                    }

                    if (errors[i].toLowerCase().includes('teléfono')) {
                        errorContainerId = 'telefonoError';
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
                document.getElementById('nombreError').textContent = '';
                document.getElementById('ap1Error').textContent = '';
                document.getElementById('nifError').textContent = '';
                document.getElementById('telefonoError').textContent = '';
                document.getElementById('emailError').textContent = '';
            }
        });
    </script>


</x-guest-layout>
