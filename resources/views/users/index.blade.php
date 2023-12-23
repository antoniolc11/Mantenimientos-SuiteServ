<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Operarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="" x-data="buscarUsuario" x-init="buscarUsuario2">
                {{-- Buscador de usuarios --}}
                @include('users.partials.buscador_users')

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    {{-- Mostrar los mensajes de exito y error. --}}
                    <div class="h-9">
                        @if (session('success'))
                            <x-success-alert :status="session('success')" />
                        @endif

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

                        <div class="overflow-x-auto">
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
                                    <!-- Sección para manejar cuando no hay resultados -->
                                    <template x-if="resultados.length === 0">
                                        <tr>
                                            <td colspan="6" class="h-full">
                                                <div class="flex items-center justify-center h-full mt-6 mb-6">
                                                    <p class="text-center font-bold text-gray-800">No hay usuarios que mostrar</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <!-- Fin de la sección -->

                                    <!-- Sección para mostrar resultados -->
                                    <template x-else x-for="usuario in resultados" :key="usuario.id">
                                        <tr class="border-b dark:border-neutral-500">
                                            <!-- Celda para el NIF -->
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">
                                                <a :href="`${routeShow.replace(':user_id', usuario.id)}`" x-text="usuario.nif"></a>
                                            </td>

                                            <!-- Celda para el nombre completo -->
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">
                                                <a :href="`${routeShow.replace(':user_id', usuario.id)}`"
                                                    x-text="`${usuario.nombre} ${usuario.primer_apellido} ${usuario.segundo_apellido}`"></a>
                                            </td>

                                            <!-- Celda para el teléfono -->
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium" x-text="usuario.telefono"></td>

                                            <!-- Celda para el correo electrónico -->
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium" x-text="usuario.email"></td>

                                            <!-- Celda para botones de acción -->
                                            <td>
                                                <div class="w-full text-center">
                                                    <!-- Botón de editar -->
                                                    <a :href="`${routeEdit.replace(':user_id', usuario.id)}`">
                                                        <button title="Editar" type="submit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700" viewBox="0 0 512 512">
                                                                <!-- Icono de editar -->
                                                                <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                                            </svg>
                                                        </button>
                                                    </a>

                                                    <!-- Botones de bloquear/desbloquear -->
                                                    <template x-if="usuario.status === 1">
                                                        <button title="Bloquear" @click="bloquearUsuario(usuario)" class="ml-4">
                                                            <!-- Icono de bloquear -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700" viewBox="0 0 512 512">
                                                                <path fill="#ff0000" d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                                                            </svg>
                                                        </button>
                                                    </template>
                                                    <template x-if="usuario.status === 0">
                                                        <button title="Desbloquear" @click="desbloquearUsuario(usuario)" class="ml-4">
                                                            <!-- Icono de desbloquear -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700" viewBox="0 0 448 512">
                                                                <path fill="#1b5e0d" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                                            </svg>
                                                        </button>
                                                    </template>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <!-- Fin de la sección -->
                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
