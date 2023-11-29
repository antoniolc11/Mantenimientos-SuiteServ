<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Aspirantes') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">



            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="h-9">
                    {{-- Mostrar los mensajes de exito. --}}
                    @if (session('success'))
                        <x-success-alert :status="session('success')" />
                    @endif

                    {{-- Mostrar los mensajes de error. --}}
                    @if (session('error'))
                        <x-error-alert :messages="session('error')" />
                    @endif
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <table id="tablaAspirantes" class="min-w-full text-center text-sm font-light">
                        <thead
                            class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                            <tr>
                                <th scope="col" class=" px-6 py-4">Nif</th>
                                <th scope="col" class=" px-6 py-4">Nombre</th>
                                <th scope="col" class=" px-6 py-4">Telefono</th>
                                <th scope="col" class=" px-6 py-4">Email</th>
                                <th scope="col" class=" px-6 py-4">Curriculum</th>
                                <th scope="col" class=" px-6 py-4">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if ($aspirantes->isEmpty())
                                <tr>
                                    <td colspan="6" class="h-full">
                                        <div class="flex items-center justify-center h-full mt-6">
                                            <p class="text-center font-bold text-gray-800">No hay aspirantes aún</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                <!-- Aquí va tu estructura de tabla para mostrar los aspirantes -->
                                @foreach ($aspirantes as $aspirante)
                                    <tr class="border-b dark:border-neutral-500">
                                        <td class="whitespace-nowrap  px-6 py-4 font-medium"><a
                                                href="{{ route('aspirantes.show', $aspirante) }}">{{ $aspirante->nif }}</a>
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">
                                            <a
                                                href="{{ route('aspirantes.show', $aspirante) }}">{{ $aspirante->nombre . ' ' . $aspirante->primer_apellido . ' ' . $aspirante->segundo_apellido }}</a>
                                        </td>
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">
                                            {{ substr($aspirante->telefono, 0, 3) }}
                                            {{ substr($aspirante->telefono, 3, 3) }}
                                            {{ substr($aspirante->telefono, 6) }}
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">{{ $aspirante->email }}</td>
                                        <td>
                                            <a href="{{ Storage::url($aspirante->curriculum) }}" target="_blank">
                                                <i class="fas fa-file-pdf"></i> Descargar el Curriculum
                                            </a>
                                        </td>
                                        <td class="px-6 text-center">


                                            <button data-modal-toggle="popup-modal{{ $aspirante->id }}"
                                                title="Descartar" type="submit">
                                                <img src="{{ asset('imagenes/boton-x.png') }}" alt="Icono"
                                                    class="w-6 h-6 mr-2 inline max-w-xs transition duration-300 ease-in-out hover:-scale-x-125" />
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach ($aspirantes as $aspirante)
        <!-- Ventana modal para editar un aspirante -->

        {{-- Ventana modal para borrar al aspirante --}}
        <div id="popup-modal{{ $aspirante->id }}" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 ">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-black bg-transparent  hover:text-gray-500 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-toggle="popup-modal{{ $aspirante->id }}">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                    <div class="p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" aria-hidden="true" class="mx-auto mb-4 w-10 h-10 text-red-400 dark:text-gray-200"
                            fill="#ff0000" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <!--!Font Awesome Free 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path fill="#d20404" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-black  dark:text-gray-400">¿Seguro que desea descartar
                            este
                            aspirante?</h3>
                        <form action="{{ route('aspirantes.destroy', $aspirante) }}" method="POST" class="inline">
                            @method('DELETE')
                            @csrf

                            <button data-modal-toggle="popup-modal{{ $aspirante->id }}" type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                Sí, seguro
                            </button>
                            <button data-modal-toggle="popup-modal{{ $aspirante->id }}" type="button"
                                class="text-black  bg-white hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No,
                                cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
