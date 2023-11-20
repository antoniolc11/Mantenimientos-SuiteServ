<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>
    <div class="container mt-10 mx-auto flex justify-center items-center p-2  md:p-0 ">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-5">
                <div class="p- text-gray-900 dark:text-gray-100">
                    {{-- Muestra el botón para crear la nueva incidencia solo si es usuario de dirección o supervisión --}}
                    @if (auth()->user()->esDepartamentoDireccion() ||
                            auth()->user()->esDepartamentosupervision())
                        <div class="flex justify-end">
                            <a href="{{ route('incidencias.create') }}">
                                <input type="submit" value="Nueva incidencia"
                                    class="bg-black text-white font-bold text-lg hover:bg-gray-700 py-1 mt-4 px-2 w-48 mb-1" />
                            </a>
                        </div>
                    @endif

                    {{-- Tabla que muestra las incidencias. --}}
                    <table id="tablaIncidencias" class="min-w-full text-center text-sm font-light">
                        <thead
                            class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                            <tr>
                                <th scope="col" class=" px-6 py-4">Nº incidencia</th>
                                <th scope="col" class=" px-6 py-4">Prioridad</th>
                                <th scope="col" class=" px-6 py-4">Categoría</th>
                                <th scope="col" class=" px-6 py-4">Fecha</th>
                                <th scope="col" class=" px-6 py-4">Departamento</th>
                                @if (auth()->user()->esDepartamentoDireccion() ||
                                        auth()->user()->esDepartamentosupervision())
                                    <th scope="col" class=" px-6 py-4">Creador</th>
                                    <th scope="col" class=" px-6 py-4">Asignada</th>
                                @endif
                                <th scope="col" class=" px-6 py-4">Estado</th>
                                <th scope="col" class=" px-6 py-4">Ubicación</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($incidencias->isEmpty())
                                <tr>
                                    <td colspan="9" class="h-full">
                                        <div class="flex items-center justify-center h-full mt-6 mb-6">
                                            <p class="text-center font-bold text-gray-800">No hay incidencias aún</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($incidencias as $incidencia)
                                    <tr class="border-b dark:border-neutral-500">
                                        <td class="whitespace-nowrap  px-6 py-4 font-medium"><a
                                                href="{{ route('incidencias.show', $incidencia) }}">{{ $incidencia->numero }}</a>
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4"><span
                                                class="h-5 w-5 inline-block rounded-full {{ $incidencia->prioridadColor() }}"></span>
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->categoria->nombre }}
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->fecha }}</td>
                                        <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->departamento->nombre }}
                                        </td>
                                        @if (auth()->user()->esDepartamentoDireccion() ||
                                                auth()->user()->esDepartamentosupervision())
                                            <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->creador->nombre }}
                                            </td>
                                            <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->asignado->nombre }}
                                            </td>
                                        @endif
                                        <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->estado->nombre }}</td>
                                        <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->ubicacion->nombre }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</x-app-layout>
