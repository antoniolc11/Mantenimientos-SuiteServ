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
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto ">

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
                                    <tr class="border-b dark:border-neutral-500 hover:bg-gray-200">
                                        <td class="whitespace-nowrap  px-6 py-4 font-medium">
                                               {{ $aspirante->nif }}
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">
                                            {{ $aspirante->nombre . ' ' . $aspirante->primer_apellido . ' ' . $aspirante->segundo_apellido }}
                                        </td>
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">
                                            {{ substr($aspirante->telefono, 0, 3) }}
                                            {{ substr($aspirante->telefono, 3, 3) }}
                                            {{ substr($aspirante->telefono, 6) }}
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">{{ $aspirante->email }}</td>
                                        <td class="px-6 py-4 flex justify-center items-center">
                                            @if ($aspirante->curriculum)
                                                <button
                                                    class="open-curriculum-button relative flex items-center hover:scale-125 text-sm font-medium  hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-600"
                                                    data-curriculum-link="{{ Storage::url($aspirante->curriculum) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="16"
                                                        width="18" viewBox="0 0 576 512" class="mr-2">
                                                        <path fill="#000000"
                                                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                    </svg>
                                                    CV
                                                </button>
                                                @else
                                                    <p>N/C</p>
                                            @endif
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
    <div class="fixed bottom-0 left-0 w-full bg-gray-200 p-4">
        <div class="mx-auto max-w-screen-md">
            {{ $aspirantes->links('components.paginate') }}
        </div>
    </div>
    <script>
        // Agrega un evento de clic a los botones "Descargar el Curriculum"
        document.querySelectorAll('.open-curriculum-button').forEach(function(button) {
            button.addEventListener('click', function() {
                // Obtiene el enlace al curriculum del atributo data-curriculum-link
                var curriculumLink = this.getAttribute('data-curriculum-link');

                // Verifica si el enlace está presente antes de intentar abrir la ventana
                if (curriculumLink) {
                    // Obtiene el ancho y el alto de la pantalla
                    var screenWidth = window.screen.width;
                    var screenHeight = window.screen.height;

                    // Abre una nueva ventana (pop-up) que ocupa el 100% de la pantalla
                    window.open(curriculumLink, "Curriculum", "width=" + screenWidth + ",height=" + screenHeight);
                } else {
                    console.error("Data attribute data-curriculum-link not found on the button:", this);
                }
            });
        });
    </script>



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
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" aria-hidden="true"
                            class="mx-auto mb-4 w-10 h-10 text-red-400 dark:text-gray-200" fill="#ff0000"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <!--!Font Awesome Free 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path fill="#d20404"
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
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
