      {{-- Ventana modal para borrar al incidencia --}}
      <div id="reabrir-modal{{ $incidencia->id }}" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 ">
                <button type="button"
                    class="absolute top-3 right-2.5 text-black bg-transparent  hover:text-gray-500 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="reabrir-modal{{ $incidencia->id }}">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 512 512" aria-hidden="true" class="mx-auto mb-4 w-10 h-10 text-red-400 dark:text-gray-200"
                        fill="#ff0000" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <!--!Font Awesome Free 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                        <path fill="#d20404" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-black  dark:text-gray-400">¿Seguro que desea reabrir
                        esta
                        incidencia?</h3>
                    <form action="{{ route('incidencias.reabrir', $incidencia) }}" method="POST"
                        class="inline">
                        @method('put')
                        @csrf

                        <button data-modal-toggle="reabrir-modal{{ $incidencia->id }}" type="submit"
                            class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Sí, seguro
                        </button>
                        <button data-modal-toggle="reabrir-modal{{ $incidencia->id }}" type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">No,
                            cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
