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

                    <div>
                        <script>
                            window.routeShow = "{{ route('users.show', ['user' => ':user_id']) }}";
                            window.routeEdit = "{{ route('users.edit', ['user' => ':user_id']) }}";

                            function buscarUsuario() {
                                return {
                                    routeShow: window.routeShow,
                                    primer_apellido: '',
                                    email: '',
                                    departamento: '',
                                    nombre: '',
                                    resultados: [],

                                    bloquearUsuario(usuario) {
                                        // Llamada a la API para bloquear al usuario
                                        axios.post(`/usuario/addbanned/${usuario.id}`)
                                            .then(response => {
                                                console.log('Usuario bloqueado:', response.data);
                                                usuario.status = 0;

                                                // Luego, ejecutar la búsqueda nuevamente para actualizar la interfaz
                                                this.buscarUsuario2();
                                                // Puedes realizar acciones adicionales si es necesario
                                            })
                                            .catch(error => {
                                                console.error('Error al bloquear usuario:', error);
                                            });
                                    },

                                    desbloquearUsuario(usuario) {
                                        // Llamada a la API para desbloquear al usuario
                                        axios.post(`/usuario/outbanned/${usuario.id}`)
                                            .then(response => {
                                                console.log('Usuario desbloqueado:', response.data);
                                                usuario.status = 1;
                                                // Luego, ejecutar la búsqueda nuevamente para actualizar la interfaz
                                                this.buscarUsuario2();
                                                // Puedes realizar acciones adicionales si es necesario
                                            })
                                            .catch(error => {
                                                console.error('Error al desbloquear usuario:', error);
                                            });
                                    },



                                    buscarUsuario2() {
                                        let nombre = this.nombre.trim()

                                        let primer_apellido = this.primer_apellido.trim()
                                        let email = this.email.trim()
                                        let departamento = this.departamento.trim()

                                        // Realiza una llamada AJAX a tu servidor para buscar usuario por nombre

                                        axios.get(`/buscador/user`, {
                                                params: {
                                                    nombre: nombre,
                                                    primer_apellido: this.primer_apellido,
                                                    email: this.email,
                                                    departamento: this.departamento,
                                                }

                                            })
                                            .then(response => {
                                                this.resultados = response.data.usuarios;

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
                    <div class="h-9">
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

                        <table id="tablaUsers" class="min-w-full  text-sm font-light">
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

                            <tbody>
                                {{-- El contenido de la tabla de usuarios se encuentra en la vista llamada _busquedaUsuarios --}}

                                <template x-if="resultados.length === 0">
                                    <tr>
                                        <td colspan="6" class="h-full">
                                            <div class="flex items-center justify-center h-full mt-6 mb-6">
                                                <p class="text-center font-bold text-gray-800">No hay usuarios aún</p>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                <template x-else x-for="usuario in resultados" :key="usuario.id">

                                    <tr class="border-b dark:border-neutral-500">
                                        <td class="whitespace-nowrap  px-6 py-4 font-medium">
                                            <a :href="`${routeShow.replace(':user_id', usuario.id)}`"
                                                x-text="usuario.nif"></a>
                                        </td>

                                        <td class="whitespace-nowrap  px-6 py-4 font-medium">
                                            <a :href="`${routeShow.replace(':user_id', usuario.id)}`"
                                                x-text="`${usuario.nombre} ${usuario.primer_apellido} ${usuario.segundo_apellido}`"></a>
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4 font-medium" x-text="usuario.telefono">
                                        </td>

                                        <td class="whitespace-nowrap  px-6 py-4 font-medium" x-text="usuario.email">
                                        </td>
                                        <td>
                                            <div class="w-full text-center">
                                                <a :href="`${routeEdit.replace(':user_id', usuario.id)}`">
                                                    <button title="Editar" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700"
                                                            viewBox="0 0 512 512">
                                                            <path
                                                                d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                                        </svg>
                                                    </button>
                                                </a>

                                                <template x-if="usuario.status === 1">
                                                    <!-- Botón para bloquear el perfil del usuario -->
                                                    <button title="Bloquear" @click="bloquearUsuario(usuario)"
                                                        class="ml-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700"
                                                            viewBox="0 0 512 512">
                                                            <path fill="#ff0000"
                                                                d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                                                        </svg>
                                                    </button>
                                                </template>
                                                <template x-if="usuario.status === 0">
                                                    <!-- Botón para desbloquear el perfil del usuario -->
                                                    <button title="Desbloquear" @click="desbloquearUsuario(usuario)"
                                                        class="ml-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700"
                                                            viewBox="0 0 448 512">
                                                            <path fill="#1b5e0d"
                                                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                                        </svg>
                                                    </button>
                                                </template>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
