<x-app-layout>

    <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-14">
        <div class="h-9 mb-2">
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


        <!-- Register Section -->


        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white text-center mb-6">Edición de usuario 
        </h2>
        <form id="usersRegistro" class="flex flex-col pt-3 md:pt-8" method="POST" action="{{ route('users.update', $usuario) }}">
            @method('put')
            @csrf {{-- agrega el campo oculto con el token (si no ponemos esto no valdrá el envio del formulario) --}}
            <div class="grid grid-cols-1 gap-6  sm:grid-cols-2">
                <!-- Nombre -->
                <div>
                    <x-input-label for="nombre" :value="__('Nombre')" />
                    <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $usuario->nombre)"
                         autofocus autocomplete="nombre" placeholder="Ingresa tu primer nombre" />
                        <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="nombreError"></div>

                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <!-- Primer apellido -->
                <div>
                    <x-input-label for="primer_apellido" :value="__('Primer apellido')" />
                    <x-text-input id="primer_apellido" class="block mt-1 w-full" type="text" name="primer_apellido"
                        :value="old('primer_apellido', $usuario->primer_apellido)"  autofocus autocomplete="primer_apellido"
                        placeholder="Ingresa tu primer apellido" />
                        <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="ap1Error"></div>

                    <x-input-error :messages="$errors->get('primer_apellido')" class="mt-2" />
                </div>

                <!-- Segundo apellido -->
                <div>
                    <x-input-label for="segundo_apellido" :value="__('Segundo apellido')" />
                    <x-text-input id="segundo_apellido" class="block mt-1 w-full" type="text" name="segundo_apellido"
                        :value="old('segundo_apellido', $usuario->segundo_apellido)"  autofocus autocomplete="segundo_apellido"
                        placeholder="Ingresa tu segundo apellido" />
                    <x-input-error :messages="$errors->get('segundo_apellido')" class="mt-2" />
                </div>

                <!-- nif -->
                <div>
                    <x-input-label for="nif" :value="__('Nif')" />
                    <x-text-input id="nif" class="block mt-1 w-full" type="text" name="nif"
                        :value="old('nif', $usuario->nif)"  autofocus autocomplete="nif" placeholder="68741564R" />
                        <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="nifError"></div>

                    <x-input-error :messages="$errors->get('nif')" class="mt-2" />
                </div>

                <!-- telefono -->
                <div>
                    <x-input-label for="telefono" :value="__('Teléfono')" />
                    <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono"
                        :value="old('telefono', $usuario->telefono)"  autofocus autocomplete="telefono" placeholder="654456654" />
                        <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="telefonoError"></div>

                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email', $usuario->email)"  autocomplete="username" placeholder="your@email.com" />
                        <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="emailError"></div>

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>



                <!-- Departamento -->
                <div>
                    <label for="departamento">Departamento:</label>
                    <select multiple name="departamento[]" id="departamento"
                        class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-black rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent hover:border-gray-300 hover:bg-transparent">
                        @foreach ($usuario->departamentos as $departamento)
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


            <div class="w-full relative h-32 flex flex-row items-center justify-center">
                <a href="{{url()->previous()}}" class="absolute left-6 py-2 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        class="w-12 h-12 mb-2 mt-auto hover:scale-110">
                        <path
                            d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160zm352-160l-160 160c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L301.3 256 438.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0z" />
                    </svg>
                </a>


                <div class="flex flex-col items-center">
                    <input type="submit" value="Editar operario"
                        class="cursor-pointer bg-black hover:bg-gray-700 text-white font-bold w-44 py-3 mt-2 mb-2 rounded" />
                </div>

            </div>
        </form>
        </div>

        </div>

    </section>

    <script src="{{ asset('js/validation_users.js') }}"></script>
</x-app-layout>
