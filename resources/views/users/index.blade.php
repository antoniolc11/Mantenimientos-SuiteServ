<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Operarios') }}
        </h2>
    </x-slot>

    <div class="py-12 overflow-x-auto" x-data="buscarUsuario" x-init="buscarUsuario2">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div>
                {{-- Buscador de usuarios --}}
                @include('users.partials.buscador_users')

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="height: 450px; overflow-y: auto;">
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
                                    <!-- Sección para mostrar resultados -->
                                    <template x-else x-for="usuario in resul" :key="usuario.id">
                                        <tr class="border-b dark:border-neutral-500 hover:bg-gray-200">
                                            <!-- Celda para el NIF -->
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">
                                                <a :href="`${routeShow.replace(':user_id', usuario.id)}`"
                                                    x-text="usuario.nif"></a>
                                            </td>

                                            <!-- Celda para el nombre completo -->
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">
                                                <a :href="`${routeShow.replace(':user_id', usuario.id)}`"
                                                    x-text="`${usuario.nombre} ${usuario.primer_apellido} ${usuario.segundo_apellido}`"></a>
                                            </td>

                                            <!-- Celda para el teléfono -->
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium"
                                                x-text="usuario.telefono"></td>

                                            <!-- Celda para el correo electrónico -->
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium" x-text="usuario.email">
                                            </td>

                                            <!-- Celda para botones de acción -->
                                            <td class="">
                                                <div class="w-full text-center flex items-center">
                                                    <!-- Botón de editar -->
                                                    <a :href="`${routeEdit.replace(':user_id', usuario.id)}`">
                                                        <button title="Editar" type="submit">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700"
                                                                viewBox="0 0 512 512">
                                                                <!-- Icono de editar -->
                                                                <path
                                                                    d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                                            </svg>
                                                        </button>
                                                    </a>

                                                    <!-- Botón para ver el historial de incidencias del usuario -->
                                                    <a :href="`${routeview.replace(':user_id', usuario.id)}`">
                                                        <button title="Ver historial de incidencias" type="submit"  class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700 ml-4">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                                <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>
                                                            </svg>
                                                        </button>
                                                    </a>

                                                    <!-- Botones de bloquear/desbloquear -->
                                                    <template x-if="usuario.status === 1">
                                                        <button title="Bloquear" @click="bloquearUsuario(usuario)"
                                                            class="ml-4">
                                                            <!-- Icono de bloquear -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700"
                                                                viewBox="0 0 512 512">
                                                                <path fill="#ff0000"
                                                                    d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                                                            </svg>
                                                        </button>
                                                    </template>
                                                    <template x-if="usuario.status === 0">
                                                        <button title="Desbloquear" @click="desbloquearUsuario(usuario)"
                                                            class="ml-4">
                                                            <!-- Icono de desbloquear -->
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
                                    <!-- Fin de la sección -->
                                    <!-- Sección para manejar cuando no hay resultados -->
                                    <template x-if="resultados.length === 0">
                                        <tr>
                                            <td colspan="6" class="h-full">
                                                <div class="flex items-center justify-center h-full mt-6 mb-6">
                                                    <p class="text-center font-bold text-gray-800">No hay usuarios que
                                                        mostrar</p>
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
        <!-- Paginación -->
        <div class="flex flex-col items-center bottom-0 left-0 w-full bg-gray-100 p-4" x-show="totalUsuarios > usuariosPorPagina">
            <!-- Help text -->

            <span class="text-sm text-gray-700 dark:text-gray-400">
                Mostrando
                <span class="font-semibold text-gray-900 dark:text-white" x-text="paginaActual">

                </span>

                de
                <span class="font-semibold text-gray-900 dark:text-white"
                    x-text="Math.ceil(totalUsuarios / usuariosPorPagina)">

                </span>
                Páginas
            </span>
            <!-- Buttons -->
            <div class="inline-flex mt-2 xs:mt-0">
                <button
                    class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-500 rounded-l cursor-not-allowed"
                    disabled x-show="paginaActual === 1">
                    Anterior
                </button>

                <button @click="cambiarPagina(paginaActual - 1)" x-show="paginaActual != 1"
                    class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Anterior
                </button>

                <button
                    class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-500 rounded-e cursor-not-allowed"
                    disabled x-show="paginaActual === Math.ceil(totalUsuarios / usuariosPorPagina)">
                    Siguiente
                </button>

                <button @click="cambiarPagina(paginaActual + 1)"
                    x-show="paginaActual != Math.ceil(totalUsuarios / usuariosPorPagina)"
                    class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-s border-gray-700 rounded-e hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Siguiente</button>
            </div>
        </div>
</x-app-layout>
