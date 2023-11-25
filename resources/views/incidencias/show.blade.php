<x-app-layout>
    <section class="max-w-2xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-20 ">
        <table class="min-w-full">
            <thead class="border-b">
                <tr>
                    <th colspan="2" class="text-center py-4 relative">
                        <div class="flex flex-row-reverse">
                            <div x-data="{ isOpen: false }" class="relative">
                                <button @click="isOpen = !isOpen" type="button" aria-label="More options"
                                    title="More options" tabindex="0"
                                    class="types__StyledButton-sc-ws60qy-0 bcAPvy mb-9" x-ref="button">
                                    <svg aria-hidden="true" focusable="false" role="img"
                                        class="octicon octicon-kebab-horizontal" viewBox="0 0 16 16" width="16"
                                        height="16" fill="currentColor"
                                        style="display:inline-block;user-select:none;vertical-align:text-bottom;overflow:visible">
                                        <path
                                            d="M8 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM1.5 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm13 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z">
                                        </path>
                                    </svg>
                                </button>
                                <ul x-show="isOpen" @click.away="isOpen = false"
                                    class="absolute border mt-2 rounded shadow-lg bg-gray-100 p-1" x-cloak
                                    x-transition:enter="transition-transform ease-out duration-300 transform"
                                    x-transition:enter-start="scale-75"
                                    x-transition:leave="transition-transform ease-in duration-300 transform"
                                    x-transition:leave-end="scale-75"
                                    :style="{
                                        top: $refs.button ? ($refs.button.offsetTop + $refs.button.offsetHeight - 2) +
                                            'px' : 'auto',
                                        left: $refs.button ? 'auto' :
                                        '0', // Deja la izquierda como 'auto' para que se ajuste al contenido
                                        right: $refs.button ? ($refs.button.offsetLeft + $refs.button.offsetWidth - 8) +
                                            'px' : 'auto',
                                        'margin-top': '-2px',
                                        'width': 'max-content'
                                    }">
                                    <!-- Contenido del menú desplegable -->
                                    @if (auth()->user()->esDepartamentoDireccion() ||
                                            auth()->user()->esDepartamentosupervision())
                                        <li class="text-black w-full p-1 hover:bg-gray-200 font-normal text-start">
                                            <a href="{{ route('incidencias.edit', $incidencia) }}">Editar</a>
                                        </li>
                                    @endif
                                    {{-- TODO: barajar la opción de cerrar incidencia directamente --}}
                                    <li class="text-black w-full p-1 hover:bg-gray-200 font-normal">
                                        <a href="{{ route('incidencias.edit', $incidencia) }}">Pasar a resuelta</a>
                                    </li>

                                    @if ($incidencia->estado_id == 3)
                                        <li class="text-black w-full p-1 hover:bg-gray-200 font-normal">
                                            <a href="{{ route('generate-pdf', $incidencia) }}" target="_blank"
                                                class="btn btn-primary">
                                                <button data-modal-hide="defaultModal" type="button">Parte
                                                    de trabajo</button>
                                            </a>
                                        </li>
                                    @endif
                                    <!-- Agrega más elementos según sea necesario -->
                                </ul>

                            </div>

                            <div class="w-full">
                                <h2
                                    class="text-lg font-semibold text-gray-700 capitalize dark:text-white mb-2 text-center">
                                    Ficha de incidencia
                                </h2>
                            </div>
                        </div>
                    </th>
                </tr>

                <tr class="border-t border-gray-200">
                    <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">Número de
                        Incidencia:</th>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $incidencia->numero }}
                    </td>
                </tr>

                <tr class="border-t border-gray-200">
                    <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha:</th>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $incidencia->fecha }}
                    </td>
                </tr>

                <tr class="border-t border-gray-200">
                    <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad:
                    </th>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $incidencia->prioridad }}

                    </td>
                </tr>

                <tr class="border-t border-gray-200">
                    <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría:
                    </th>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $incidencia->categoria->nombre }}
                    </td>
                </tr>

                <tr class="border-t border-gray-200">
                    <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento
                    </th>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $incidencia->departamento->nombre }}
                    </td>
                </tr>

                @if (auth()->user()->esDepartamentoDireccion() ||
                        auth()->user()->esDepartamentosupervision())
                    <tr class="border-t border-gray-200">
                        <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">Creador:
                        </th>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $incidencia->creador->nombre }}
                        </td>
                    </tr>

                    <tr class="border-t border-gray-200">
                        <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">Asignado:
                        </th>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $incidencia->asignado->nombre }}
                        </td>
                    </tr>
                @endif

                <tr class="border-t border-gray-200">
                    <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">Estado:
                    </th>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $incidencia->estado->nombre }}
                    </td>
                </tr>

                <tr class="border-t border-gray-200">
                    <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación:
                    </th>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $incidencia->ubicacion->nombre }}
                    </td>
                </tr>

                <tr class="border-t border-gray-200">
                    <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción:
                    </th>
                    <td class="px-6 py-4 whitespace">
                        {{ $incidencia->descripcion }}
                    </td>
                </tr>


                <form method="POST"
                    action="{{ route('incidencias.cambiar-estado', ['incidencia' => $incidencia->id]) }}">
                    @csrf
                    @method('PUT')

                    @if ($incidencia->estado->nombre == 'En curso')
                        <tr class="border-t border-gray-200">
                            <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Trabajo realizado:
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <textarea name="descripcion" id="descripcion" rows="4"
                                    class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent"></textarea>
                            </td>
                        </tr>
                    @endif


            </thead>

            <tfoot>
                <tr>
                    <td colspan="2" class="text-center py-4">
                        @if ($incidencia->estado->nombre != 'Finalizado')
                            <a href="{{ route('incidencias.cambiar-estado', ['incidencia' => $incidencia->id]) }}">
                                <button type="submit"
                                    class="bg-neutral-800 hover:bg-gray-700 text-white font-bold w-32 py-3 rounded">
                                    @if ($incidencia->estado->nombre == 'Pendiente')
                                        Iniciar
                                    @else
                                        Finalizar
                                    @endif
                                </button>
                            </a>
                        @endif

                        </form>
                        {{-- Boton que abre la modal, que muestra los historiales de la incidencia. --}}
                        <button type="button"
                            class="bg-neutral-800 hover:bg-gray-700 text-white font-bold w-32 py-3 rounded"
                            data-modal-target="defaultModal" data-modal-toggle="defaultModal" Toggle modal>
                            Ver Historial
                        </button>
                    </td>

                </tr>
            </tfoot>
        </table>

        <!-- Ventana modal que muestra el historial de la incidencia-->
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">

                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Historial de la incidencia Nº: {{ $incidencia->numero }}
                        </h3>

                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="defaultModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-6 space-y-6">

                        @foreach ($historiales as $historial)
                            @if ($historial['estado_id'] == 1)
                                <h5 class="text-s font-semibold text-gray-900 dark:text-white">
                                    Creación de la incidencia:
                                </h5>
                                <div
                                    class="flex items-center space-x-2 border-b  border-gray-200 rounded-b dark:border-gray-600">

                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-6">
                                        Sé genera la incidencia con fecha: {{ $historial->fecha }} a las:
                                        {{ $historial->hora_inicio }}.
                                    </p>
                                </div>
                            @endif

                            @if ($historial['estado_id'] == 2)
                                <h5 class="text-s font-semibold text-gray-900 dark:text-white">
                                    En curso.
                                </h5>
                                <div
                                    class="flex items-center space-x-2 border-b border-gray-200 rounded-b dark:border-gray-600">

                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-6">
                                        Sé inicia la incidencia con fecha: {{ $historial->fecha }} Iniciada a las:
                                        {{ $historial->hora_inicio }}.
                                    </p>

                                </div>
                            @endif

                            @if ($historial['estado_id'] == 3)
                                <h5 class="text-s font-semibold text-gray-900 dark:text-white">
                                    Finalizada.
                                </h5>
                                <div
                                    class="flex items-center space-x-2 border-b border-gray-200 rounded-b dark:border-gray-600">


                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-6">
                                        Sé finaliza la incidencia con fecha: {{ $historial->fecha }} Finalizada a las:
                                        {{ $historial->hora_fin }}.
                                    </p>
                                </div>
                            @endif
                        @endforeach

                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="defaultModal" type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Aceptar</button>


                        @if ($incidencia->estado_id == 3)
                            <a href="{{ route('generate-pdf', $incidencia) }}" target="_blank"
                                class="btn btn-primary">
                                <button data-modal-hide="defaultModal" type="button"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Parte
                                    de trabajo</button>
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
