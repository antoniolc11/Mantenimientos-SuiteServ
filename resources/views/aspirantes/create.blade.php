<x-guest-layout>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <form method="POST" action="{{ route('aspirantes.store') }}" class="mb-6 mt-6 ml-6 mr-6" enctype="multipart/form-data">
            @csrf


            <h1 id="titulo" class="vagbold text-gray-700 text-5xl mb-16 font-bold font-montserrat">
                Trabaja con nosotros
            </h1>

            <!-- Nombre -->
            <div>
                <x-input-label for="nombre" :value="__('Nombre')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')"
                    required autofocus autocomplete="nombre" />
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

            <!-- TODO: hace falta cambiar esto, la idea es mandar un correo cuando se registre la solicitud al correo,
                 con un boton que vaya a una vista donde tenga la posibilidad de adjuntar su curriculum -->
            <div class="mt-4">
                <input type="file" name="curriculum" accept=".pdf, .doc, .docx">
            </div>

            <div class="w-full relative h-32 flex flex-row items-center justify-center">
                <a href="{{route('login')}}" class="absolute left-6 py-2 mt-2">
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

</x-guest-layout>
