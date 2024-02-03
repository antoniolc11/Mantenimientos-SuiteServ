<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Incidencias') }}
            {{-- Se muestra el numero de incidencias activas al usuario sin privilegios --}}
            @if (
                !auth()->user()->esDepartamentoDireccion() &&
                    !auth()->user()->esDepartamentosupervision())
                @if ($numero != 0)
                    <span class="text-red-500">({{ $numero }})</span>
                @endif
            @endif
        </h2>
    </x-slot>

    <div x-data="buscarIncidencia" x-init="buscarIncidencia2" class="h-full">
        @include('incidencias.partials.buscador_incidencias')

        <div class="w-auto mx-auto sm:px-6  mt-5 mb-20">
            <div class="bg-white p-5 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 dark:text-gray-100 w-full">

                    {{-- Muestra el botón para crear la nueva incidencia solo si es usuario de dirección o supervisión --}}
                    @if (auth()->user()->esDepartamentoDireccion() ||
                            auth()->user()->esDepartamentosupervision())
                        <div class="flex justify-end">
                            <a href="{{ route('incidencias.create') }}">
                                <input type="submit" value="Nueva incidencia"
                                    class="cursor-pointer bg-black hover:bg-gray-700 text-white font-bold w-40 py-3 mb-2 rounded" />
                            </a>
                        </div>
                    @endif

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
                                    @if (auth()->user()->esDepartamentoDireccion() ||
                                            auth()->user()->esDepartamentosupervision())
                                        <th scope="col" class=" px-6 py-4">Asignada</th>
                                    @endif
                                    <th scope="col" class=" px-6 py-4">Estado</th>
                                    <th scope="col" class=" px-6 py-4">Ubicación</th>
                                </tr>
                            </thead>
                            <tbody x-html="resultados">
                                {{-- Aquí si muestran los resultados de la tabla que se encuentran en el archivo _busqueda.blade.php --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Buscador_incidencias.js') }}"></script>

    <!-- Botón para desplazar hacía arriba del todo. -->
    <div id="subirArriba" class="hidden fixed bottom-4 left-4 p-2 bg-gray-800 text-white rounded cursor-pointer" title="Subir arriba">
        <svg fill="none" viewBox="0 0 448 512" stroke="currentColor"
        class="h-6 w-6 transform scale-100 hover:scale-125 transition-transform duration-300 ease-in-out">
            <path fill="#edf1f8"  d="M246.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 109.3 361.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160zm160 352l-160-160c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 301.3 361.4 438.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3z"></path>
        </svg>
    </div>

    <script src="{{ asset('js/subir.js') }}"></script>
</x-app-layout>
