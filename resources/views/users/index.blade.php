<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Operarios') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="" x-data="buscarUsuario" x-init="buscarUsuario2">
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
                                <div class="flex flex-col" >
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
                                        :value="old('email')" required autocomplete="username"
                                        placeholder="tu@email.com" x-model="email" x-on:keyup="buscarUsuario2"/>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div>
                        <script>
                            function buscarUsuario() {
                                return {
                                    primer_apellido: '',
                                    email: '',
                                    nombre: '',
                                    resultados: [],
                                    buscarUsuario2() {
                                        let nombre = this.nombre.trim()

                                        let primer_apellido = this.primer_apellido.trim()
                                        let email = this.email.trim()

                                        // Realiza una llamada AJAX a tu servidor para buscar usuario por nombre

                                        axios.get(`/buscador/user`, {
                                                params: {
                                                    nombre: nombre,
                                                    primer_apellido: this.primer_apellido,
                                                    email: this.email,
                                                }

                                            })
                                            .then(response => {
                                                this.resultados = response.data;

                                            })
                                            .catch(error => {
                                                console.error(error);
                                            });
                                    }
                                };
                            }
                        </script>
                    </div>
                </div>


                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    @if (session('success'))
                        <div class="bg-green-200 text-green-800 p-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="mr-6 ml-6 text-gray-900 dark:text-gray-100">

                        @if (auth()->user()->esDepartamentoDireccion() ||
                                auth()->user()->esDepartamentosupervision())
                            <div class="flex justify-end p-2">
                                <a href="{{ route('users.create') }}">
                                    <input type="submit" value="Nuevo usuario"
                                        class="cursor-pointer bg-black hover:bg-gray-700 text-white font-bold w-32 py-3 rounded" />
                                </a>
                            </div>
                        @endif

                        <table id="tablaUsers" class="min-w-full text-center text-sm font-light">
                            <thead
                                class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                                <tr>
                                    <th scope="col" class=" px-6 py-4">Nif</th>
                                    <th scope="col" class=" px-6 py-4">Nombre</th>
                                    <th scope="col" class=" px-6 py-4">Telefono</th>
                                    <th scope="col" class=" px-6 py-4">Email</th>
                                    <th scope="col" class=" px-6 py-4">Acciones</th>
                                </tr>
                            </thead>

                            <tbody x-html="resultados">
                                {{-- El contenido de la tabla de usuarios se encuentra en la vista llamada _busquedaUsuarios --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
