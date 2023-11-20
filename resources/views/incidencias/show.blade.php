<x-app-layout>

    <section class="max-w-2xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-20 ">
        <table class="min-w-full">
            <thead class="border-b font-medium">
                <tr>
                    <th colspan="2" class="text-center py-4">
                        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white mb-4">Ficha de
                            incidencia</h2>
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
                    <td class="px-6 py-4 whitespace-nowrap">
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
                                  class="bg-neutral-800 hover:bg-gray-700 text-white font-bold w-32 py-3 rounded">
                            Ver Historial
                        </button>
                    </td>

                </tr>
            </tfoot>
        </table>



    </section>




</x-app-layout>
