<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div x-data="buscarIncidencia" x-init="buscarIncidencia2" class="h-full">
        <div class="container mx-auto flex justify-center items-center mt-8">
            <!--
                Formulario de busqueda de incidencias, por numero, estado, categoría, prioridad, departamento.
                Según que usuario se logue se mostraran las incidencias que correspondan.
            -->
            <form action="{{ route('buscar.incidencia') }}" method="GET" x-on:submit="event.preventDefault();">
                <div class="border border-gray-300 p-6 bg-white shadow-lg rounded-lg ">
                    <div class="flex flex-col md:flex-row">
                        <div class="flex">
                            <x-text-input type="text" placeholder="Nº de incidencia" name="search" type="text"
                                x-model="searchTerm" x-on:keyup="buscarIncidencia2"
                                class="border p-2 rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent" />
                        </div>
                        <div class="pt-6 md:pt-0 md:pl-6">
                            <select x-on:change="buscarIncidencia2" x-model="porestados" name="estado" id="estado"
                                class="w-full border p-2 rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                                <option value="">Selecciona estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-6 md:pt-0 md:pl-6">
                            <select x-on:change="buscarIncidencia2" x-model="porprioridad" name="prioridad"
                                id="prioridad"
                                class="w-full border p-2 rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                                <option value="">Selecciona prioridad</option>
                                <option value="Baja">Baja</option>
                                <option value="Media">Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>
                        <div class="pt-6  md:pt-0 md:pl-6">
                            <select x-on:change="buscarIncidencia2" x-model="porcategoria" name="categoria"
                                id="categoria"
                                class="w-full border p-2 rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                                <option value="">Selecciona categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if (auth()->user()->esDepartamentoDireccion() ||
                                auth()->user()->esDepartamentosupervision() ||
                                auth()->user()->tieneMasDeUnDepartamento())
                            <div class="pt-6 md:pt-0 md:pl-6">
                                <select x-on:change="buscarIncidencia2" x-model="pordepartamento" name="departamento"
                                    id="departamento"
                                    class="w-full border p-2 rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                                <option value="">Selecciona departamento</option>
                                @foreach ($departamentosall as $departamento)
                                    @if (auth()->user()->esDepartamentoDireccion() ||
                                            auth()->user()->esDepartamentosupervision() ||
                                            auth()->user()->perteneceAlDepartamento($departamento))
                                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                    @endif
                                @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </form>

            <script>
                function buscarIncidencia() {
                    return {
                        porestados: '',
                        porprioridad: '',
                        porcategoria: '',
                        pordepartamento: '',
                        searchTerm: '',
                        resultados: [],
                        buscarIncidencia2() {
                            let campo = this.searchTerm.trim()
                            /*if (campo === '') {
                                this.resultados = [];
                                return;
                            } */

                            // Realiza una llamada AJAX a tu servidor para buscar incidencias por número
                            // Puedes usar Axios u otra biblioteca para esto
                            // Ejemplo ficticio:

                            axios.get(`/buscar-incidencia`, {
                                    params: {
                                        search: campo,
                                        estado: this.porestados,
                                        prioridad: this.porprioridad,
                                        categoria: this.porcategoria,
                                        departamento: this.pordepartamento,
                                    }
                                })
                                .then(response => {
                                    this.resultados = response.data;
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        }
                    };
                }
            </script>
        </div>


        <div class="w-auto mx-auto sm:px-6 lg:px-8 mt-5 mb-20">
            <div class="bg-white p-5 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 dark:text-gray-100 ">
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


                    <div class="overflow-x-auto">

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
                                {{-- Aquí si muestran los resultados de la tabla --}}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
</x-app-layout>
