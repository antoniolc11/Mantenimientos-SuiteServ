                {{-- Formulario de busqueda de usuarios. --}}
                <div class="container mb-3 mx-auto flex justify-center items-center p-2  md:p-0 ">
                    <!--
                      Formulario de busqueda de usuarios, por nombre, primer apellido y email.
                     -->
                    <form action="{{ route('buscadorUser.index') }}" method="GET" x-on:submit="event.preventDefault();">
                        <div class="border border-gray-300 p-4 grid grid-cols-1 gap-6 bg-white shadow-lg rounded-lg">
                            <div class="flex flex-col md:flex-row gap-4">
                                {{-- Campo de busqueda por nombre --}}
                                <div class="flex flex-col">
                                    <x-input-label for="nombre" :value="__('Nombre')" />
                                    <x-text-input id="nombre" class="block mt-2" type="text" name="nombre"
                                        :value="old('nombre')" required autofocus autocomplete="nombre"
                                        placeholder="Ingresa un nombre" x-model="nombre" x-on:keyup="buscarUsuario2" />
                                </div>

                                {{-- Campo de busqueda por primer apellido --}}
                                <div class="flex flex-col">
                                    <x-input-label for="primer_apellido" :value="__('Primer apellido')" />
                                    <x-text-input id="primer_apellido" class="block mt-2 w-full" type="text"
                                        name="primer_apellido" :value="old('primer_apellido')" required autofocus
                                        autocomplete="primer_apellido" placeholder="Ingresa el primer apellido"
                                        x-model="primer_apellido" x-on:keyup="buscarUsuario2" />
                                </div>

                                {{-- Campo de busqueda por email --}}
                                <div class="flex flex-col">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-2 w-full" type="email" name="email"
                                        :value="old('email')" required autocomplete="username" placeholder="tu@email.com"
                                        x-model="email" x-on:keyup="buscarUsuario2" />
                                </div>

                                {{-- Campo de busqueda por departamento --}}
                                <div class="flex flex-col">
                                    <x-input-label for="departamento" :value="__('Departamento')" />
                                    <select
                                        class="block mt-2  shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight border focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent"
                                        x-on:change="buscarUsuario2" x-model="departamento" name="departamento"
                                        id="departamento"
                                        class="py-2 px-3 block  h-9 w-full border  rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                                        <option value="{{ null }}">Selecciona departamento</option>
                                        @foreach ($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>
                        </div>
                    </form>
                    <script src="{{ asset('js/Buscador_users.js') }}"></script>
                    <script>
                        window.routeShow = "{{ route('users.show', ['user' => ':user_id']) }}";
                        window.routeEdit = "{{ route('users.edit', ['user' => ':user_id']) }}";
                    </script>
                </div>
