<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

            {{ __('Incidencias') }}
        </h2>
    </x-slot>

    <div class="w-auto mx-auto sm:px-6  mt-5 mb-20">
        <div class="bg-white p-5 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="text-gray-900 dark:text-gray-100 w-full">
                <div class="overflow-x-auto ">
                    {{-- Tabla que muestra las incidencias. --}}
                    <table id="tablaIncidencias" class="min-w-full text-left text-sm font-light">
                        <thead
                            class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                            <tr>
                                <th scope="col" class=" px-6 py-4">Nº incidencia</th>
                                <th scope="col" class=" px-6 py-4">Prioridad</th>
                                <th scope="col" class=" px-6 py-4">Categoría</th>
                                <th scope="col" class=" px-6 py-4">Fecha</th>
                                <th scope="col" class=" px-6 py-4">Departamento</th>
                                <th scope="col" class=" px-6 py-4">Creador</th>
                                <th scope="col" class=" px-6 py-4">Estado</th>
                                <th scope="col" class=" px-6 py-4">Ubicación</th>
                            </tr>
                        </thead>
                        <tbody x-html="resultados">
                            @forelse ($incidencias as $incidencia)
                                <!-- Tu código para mostrar cada incidencia -->
                                <tr class="border-b dark:border-neutral-500 hover:bg-gray-200">
                                    <td class="whitespace-nowrap  px-6 py-4 font-medium"><a
                                            href="{{ route('incidencias.show', $incidencia) }}">{{ $incidencia->numero }}</a>
                                    </td>
                                    <td class="whitespace-nowrap  px-6 py-4 text-center"><span
                                            class="h-5 w-5 inline-block rounded-full {{ $incidencia->prioridadColor() }}"></span>
                                    </td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->categoria->nombre }}
                                    </td>
                                    <td class="whitespace-nowrap  px-6 py-4">
                                        {{ \Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->departamento->nombre }}
                                    </td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->creador->nombre }}
                                    </td>

                                    <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->estado->nombre }}</td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->ubicacion->nombre }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="h-full">
                                        <div class="flex items-center justify-center h-full mt-6 mb-6">
                                            <p class="text-center font-bold text-gray-800">No hay incidencias que
                                                mostrar</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
    <div class="fixed bottom-0 left-0 w-full bg-gray-200 p-4">
        <div class="mx-auto max-w-screen-md">
            {{ $incidencias->links('components.paginate') }}
        </div>
    </div>

</x-app-layout>
