<div class="container mx-auto flex justify-center items-center mt-8">
    <!--
        Formulario de busqueda de incidencias, por numero, estado, categoría, prioridad, departamento.
        Según que usuario se logue se mostraran las incidencias que correspondan.
    -->
    <form action="{{ route('buscar.incidencia') }}" method="GET" x-on:submit="event.preventDefault();">
        <div class="border border-gray-300 p-6 bg-white shadow-lg rounded-lg ">
            <div class="flex flex-col md:flex-row">
                {{-- Busqueda por numero de incidencia --}}
                <div class="flex">
                    <x-text-input type="text" placeholder="Nº de incidencia" name="search" type="text"
                        x-model="searchTerm" x-on:keyup="buscarIncidencia2"
                        class="border p-2 rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent" />
                </div>

                {{-- Busqueda por estado --}}
                <div class="pt-6 md:pt-0 md:pl-6">
                    <select x-on:change="buscarIncidencia2" x-model="porestados" name="estado" id="estado"
                        class="w-full border p-2 rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        <option value="">Selecciona estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Busqueda por prioridad --}}
                <div class="pt-6 md:pt-0 md:pl-6">
                    <select x-on:change="buscarIncidencia2" x-model="porprioridad" name="prioridad" id="prioridad"
                        class="w-full border p-2 rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        <option value="">Selecciona prioridad</option>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>

                {{-- Busqueda por categoria --}}
                <div class="pt-6  md:pt-0 md:pl-6">
                    <select x-on:change="buscarIncidencia2" x-model="porcategoria" name="categoria" id="categoria"
                        class="w-full border p-2 rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        <option value="">Selecciona categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Busqueda por departamento --}}
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
</div>
