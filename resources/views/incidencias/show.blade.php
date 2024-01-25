<x-app-layout>
    @php
        //Obtenemos los usuarios del departamento al que pertenece la incidencia para mostrarlos en la modal de reasignamiento.
        $usuarios = $incidencia->departamento->users;
    @endphp

    {{-- Mostrar los mensajes de exito y error. --}}
    <div class="max-w-2xl h-9 mt-5 mb-2 mx-auto">
        @if (session('success'))
            <x-success-alert :status="session('success')" />
        @endif

        @if (session('error'))
            <x-error-alert :messages="session('error')" />
        @endif
    </div>

    <section class="max-w-2xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
        <table class="min-w-full ">
            <thead class="border-b">
                <tr>
                    <th colspan="2" class="text-center py-4 relative">
                        <div class="flex flex-row-reverse">
                            @include('incidencias.partials.desplegableOptionsInc')

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
                        {{ \Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y') }}
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


                <form id="finIncidencia" method="POST"
                    action="{{ route('incidencias.cambiar-estado', ['incidencia' => $incidencia->id]) }}">
                    @csrf
                    @method('PUT')

                    @if ($incidencia->estado->nombre == 'En curso' || $incidencia->estado->nombre == 'Reabierta')
                        <tr class="border-t border-gray-200">
                            <th class="text-left w-48 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Trabajo realizado:
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <textarea name="descripcion" id="descripcion" rows="4" placeholder="Describe aquí el trabajo realizado"
                                    class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent"></textarea>
                                <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1"
                                    id="descripcionError"></div>
                            </td>

                        </tr>
                    @endif
            </thead>

            <tfoot>
                <tr>
                    <td colspan="2" class="text-center py-4">
                        <div class="w-full relative h-32 flex flex-row items-center justify-center">
                            <a href="{{ url()->previous() }}" class="absolute left-6 py-2 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                    class="w-10 h-10 mb-2 mt-auto hover:scale-110">
                                    <path
                                        d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160zm352-160l-160 160c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L301.3 256 438.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0z" />
                                </svg>
                            </a>

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

                            {{-- Boton que abre la modal, que muestra los historiales de la incidencia. --}}
                            <button type="button"
                                class="bg-neutral-800 hover:bg-gray-700 text-white font-bold w-32 py-3 rounded ml-3"
                                data-modal-target="defaultModal" data-modal-toggle="defaultModal" Toggle modal>
                                Ver Historial
                            </button>
                        </div>
                        </form>
                    </td>
                </tr>
            </tfoot>
        </table>
    </section>
    @include('incidencias.partials.modalHistorial')
    <script src="{{ asset('js/validation_showInc.js') }}"></script>
</x-app-layout>
