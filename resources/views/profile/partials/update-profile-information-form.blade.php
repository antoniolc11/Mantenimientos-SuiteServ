<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Información del perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Actualice la información de su perfil.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>



    <form id="usersRegistro" class="flex flex-col pt-3 md:pt-8" method="POST" action="{{ route('users.update', $user) }}">
        @method('put')
        @csrf {{-- agrega el campo oculto con el token (si no ponemos esto no valdrá el envio del formulario) --}}
        <div class="grid grid-cols-1 gap-7  sm:grid-cols-2">
            <!-- Nombre -->
            <div class="mr-10">
                <x-input-label for="nombre" :value="__('Nombre')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $user->nombre)"
                     autofocus autocomplete="nombre" placeholder="Ingresa tu primer nombre" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="nombreError"></div>

                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <!-- Primer apellido -->
            <div class="mr-10">
                <x-input-label for="primer_apellido" :value="__('Primer apellido')" />
                <x-text-input id="primer_apellido" class="block mt-1 w-full" type="text" name="primer_apellido"
                    :value="old('primer_apellido', $user->primer_apellido)"  autofocus autocomplete="primer_apellido"
                    placeholder="Ingresa tu primer apellido" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="ap1Error"></div>

                <x-input-error :messages="$errors->get('primer_apellido')" class="mt-2" />
            </div>

            <!-- Segundo apellido -->
            <div class="mr-10">
                <x-input-label for="segundo_apellido" :value="__('Segundo apellido')" />
                <x-text-input id="segundo_apellido" class="block mt-1 w-full" type="text" name="segundo_apellido"
                    :value="old('segundo_apellido', $user->segundo_apellido)"  autofocus autocomplete="segundo_apellido"
                    placeholder="Ingresa tu segundo apellido" />
                <x-input-error :messages="$errors->get('segundo_apellido')" class="mt-2" />
            </div>

            <!-- nif -->
            <div class="mr-10">
                <x-input-label for="nif" :value="__('Nif')" />
                <x-text-input id="nif" class="block mt-1 w-full" type="text" name="nif" :value="old('nif', $user->nif)"
                     autofocus autocomplete="nif" placeholder="68741564R" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="nifError"></div>

                <x-input-error :messages="$errors->get('nif')" class="mt-2" />
            </div>

            <!-- telefono -->
            <div class="mr-10">
                <x-input-label for="telefono" :value="__('Teléfono')" />
                <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono', $user->telefono)"
                     autofocus autocomplete="telefono" placeholder="654456654" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="telefonoError"></div>

                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mr-10">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)"
                     autocomplete="username" placeholder="your@email.com" />
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="emailError"></div>

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>



            <!-- Departamento -->
            <div class="">
                <label for="departamento">Departamento:</label>
                <select multiple name="departamento[]" id="departamento"
                    class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-black rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent hover:border-gray-300 hover:bg-transparent">
                    @foreach ($user->departamentos as $departamento)
                        <option value="{{ $departamento->id }}" selected>{{ $departamento->nombre }}</option>
                    @endforeach


                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                    @endforeach
                </select>
                <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="departamentoError"></div>

                <x-input-error :messages="$errors->get('departamento')" class="mt-2" />

                <script>
                    new MultiSelectTag('departamento') // id
                </script>
            </div>
        </div>


        <div class="w-full relative mt-6 flex flex-row ">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>
        </div>
    </form>

    <script src="{{ asset('js/validation_users.js') }}"></script>

</section>
