<x-app-layout>

    <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-20">

        <!-- Register Section -->


        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white text-center mb-6">Edición de usuario
        </h2>
        <form class="flex flex-col pt-3 md:pt-8" method="POST" action="{{ route('users.update', $usuario) }}">
            @method('put')
            @csrf {{-- agrega el campo oculto con el token (si no ponemos esto no valdrá el envio del formulario) --}}
            <div class="grid grid-cols-1 gap-6  sm:grid-cols-2">
                <!-- Nombre -->
                <div>
                    <x-input-label for="nombre" :value="__('Nombre')" />
                    <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $usuario->nombre)"
                        required autofocus autocomplete="nombre" placeholder="Ingresa tu primer nombre" />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <!-- Primer apellido -->
                <div>
                    <x-input-label for="primer_apellido" :value="__('Primer apellido')" />
                    <x-text-input id="primer_apellido" class="block mt-1 w-full" type="text" name="primer_apellido"
                        :value="old('primer_apellido', $usuario->primer_apellido)" required autofocus autocomplete="primer_apellido"
                        placeholder="Ingresa tu primer apellido" />
                    <x-input-error :messages="$errors->get('primer_apellido')" class="mt-2" />
                </div>

                <!-- Segundo apellido -->
                <div>
                    <x-input-label for="segundo_apellido" :value="__('Segundo apellido')" />
                    <x-text-input id="segundo_apellido" class="block mt-1 w-full" type="text" name="segundo_apellido"
                        :value="old('segundo_apellido', $usuario->segundo_apellido)" required autofocus autocomplete="segundo_apellido"
                        placeholder="Ingresa tu segundo apellido" />
                    <x-input-error :messages="$errors->get('segundo_apellido')" class="mt-2" />
                </div>

                <!-- nif -->
                <div>
                    <x-input-label for="nif" :value="__('Nif')" />
                    <x-text-input id="nif" class="block mt-1 w-full" type="text" name="nif"
                        :value="old('nif', $usuario->nif)" required autofocus autocomplete="nif" placeholder="68741564R" />
                    <x-input-error :messages="$errors->get('nif')" class="mt-2" />
                </div>

                <!-- telefono -->
                <div>
                    <x-input-label for="telefono" :value="__('Teléfono')" />
                    <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono"
                        :value="old('telefono', $usuario->telefono)" required autofocus autocomplete="telefono" placeholder="654456654" />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email', $usuario->email)" required autocomplete="username" placeholder="your@email.com" />
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
                    <x-input-error :messages="$errors->get('departamento')" class="mt-2" />

                    <script>
                        new MultiSelectTag('departamento') // id
                    </script>
                </div>
            </div>
            <div class="flex justify-center">
                <input type="submit" value="Editar operario"
                    class="bg-black text-white font-bold text-lg hover:bg-gray-700 py-2 mt-8  px-2 w-52" />
            </div>
        </form>
        </div>

        </div>
    </section>
</x-app-layout>
