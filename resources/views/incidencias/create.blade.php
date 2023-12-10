<x-app-layout>
    <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-20">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Nueva orden de incidencia</h2>
        <form id="crearIncidencia" action="{{ route('incidencias.store') }}" method="POST" x-data="usuariosComponent()">
            @csrf {{-- agrega el campo oculto con el token (si no ponemos esto no valdrá el envio del formulario) --}}

            {{-- Pasa el dato del usuario que crea la incidencia, que será el id del usuario logado. --}}
            <input type="hidden" name="usuario_creador" value="{{ auth()->user()->id }}">

            {{-- El estado por defecto será el estado_id = 1 que pertenece a "Pendiente" --}}
            <input type="hidden" name="estado_id" value="1">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                {{-- Seleeciona la prioridad que va a tener la incidencia. --}}
                <div>
                    <x-input-label for="prioridad" :value="__('Prioridad')" />
                    <select name="prioridad" id="prioridad"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        <option value="Alta" {{ old('prioridad') === 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Media" {{ old('prioridad') === 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Baja" {{ old('prioridad') === 'Baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>

                {{-- Seleeciona el departamento que va a tener la incidencia. --}}
                <div>
                    <x-input-label for="departamento" :value="__('Departamento')" />
                    <select name="departamento_id" id="departamento" x-model="departamentoId"
                        x-on:change="cargarUsuarios()"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        <option value="">Selecciona un departamento</option>
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="departamentoError"></div>
                </div>

                {{-- Usuario asignado --}}
                <div>
                    <x-input-label for="usuario_asignado" :value="__('Usuario')" />
                    {{-- Carga automaticamente los usuarios que pertenecen al departamento seleccionado anteriormente,
                    ha tráves de una petición ajax --}}
                    <select name="usuario_asignado" id="usuario"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        <template x-for="usuario in usuarios" :key="usuario.id">
                            <option :value="usuario.id" x-text="usuario.nombre"></option>
                        </template>
                    </select>
                </div>

                {{-- Ubicación --}}
                <div>
                    <x-input-label for="ubicacion" :value="__('Ubicación')" />
                    <select name="ubicacion_id" id="ubicacion"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        <option value="">Selecciona una ubicación</option>
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="ubicacionError"></div>
                </div>

                {{-- Categoría --}}
                <div>
                    <x-input-label for="categoria" :value="__('Categoría')" />
                    <select name="categoria_id" id="categoria"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        <option value="">Selecciona una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="categoriaError"></div>
                </div>

                {{-- Descripción de la incidencia --}}
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                        placeholder="Describe el problema a solventar en la incidencia"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent"></textarea>
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="descripcionError"></div>
                </div>
            </div>

            {{-- Botón para crear la incidencia --}}
            <div class="w-full relative h-32 flex flex-row items-center justify-center">
                <a href="{{ route('home') }}" class="absolute left-6 py-2 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        class="w-11 mb-2 mt-auto hover:scale-110">
                        <path
                            d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160zm352-160l-160 160c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L301.3 256 438.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0z" />
                    </svg>
                </a>
                <div class="flex flex-col items-center">
                    <input type="submit" value="Generar incidencia"
                        class="cursor-pointer bg-black hover:bg-gray-700 text-white font-bold w-48 py-3 mt-2 mb-2 rounded" />
                </div>
            </div>
        </form>
    </section>

    {{--
        Carga los usuarios que pertenecen al departamento seleccionado y valida los campos:
        Departamentos, Usuario, Ubicación, Categoría y descripción
    --}}
    <script>
        /* Realiza una petición ajax a una funcion del controlador de user que devuelve al seleccionar un departamento, los usuarios del mismo
                                para mostrarlos en el select de usuario asignado. */
        function usuariosComponent() {
            return {
                usuarios: [],
                departamentoId: null,
                async cargarUsuarios() {
                    if (this.departamentoId) {
                        const response = await fetch(`/usuarios-por-departamento/${this.departamentoId}`);
                        this.usuarios = await response.json();
                    } else {
                        this.usuarios = [];
                    }
                }
            };
        }
    </script>
    <script src="{{ asset('js/validation_incidencia.js') }}"></script>
</x-app-layout>
