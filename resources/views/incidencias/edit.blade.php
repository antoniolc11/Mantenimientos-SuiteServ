<x-app-layout>
    <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-20">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Editar orden de incidencia</h2>

        <form id="crearIncidencia" action="{{ route('incidencias.update', $incidencia) }}" method="POST"
            x-data="usuariosComponent({{ old('departamento_id', $incidencia->departamento_id) }})">
            @csrf {{-- agrega el campo oculto con el token (si no ponemos esto no valdrá el envio del formulario) --}}
            @method('put')

            {{-- Pasa el dato del usuario que crea la incidencia, que será el id del usuario logado. --}}
            <input type="hidden" name="usuario_creador" value="{{ auth()->user()->id }}">

            {{-- El estado por defecto será el estado_id = 1 que pertenece a "Pendiente" --}}
            <input type="hidden" name="estado_id" value="1">


            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <div>
                    <x-input-label for="prioridad" :value="__('Prioridad')" />
                    <select name="prioridad" id="prioridad"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">

                        <option value="Alta"
                            {{ old('prioridad', $incidencia->prioridad) === 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Media"
                            {{ old('prioridad', $incidencia->prioridad) === 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Baja"
                            {{ old('prioridad', $incidencia->prioridad) === 'Baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="departamento" :value="__('Departamento')" />
                    <select name="departamento_id" id="departamento" x-model="departamentoId" x-init="cargarUsuarios()"
                        x-on:change="cargarUsuarios()"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id }}"
                                {{ old('departamento_id', $incidencia->departamento_id) === $departamento->id ? 'selected' : '' }}>
                                {{ $departamento->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="departamentoError"></div>
                </div>

                <div>
                    <x-input-label for="usuario_asignado" :value="__('Usuario')" />
                    {{-- Carga automáticamente los usuarios que pertenecen al departamento seleccionado anteriormente,
                        a través de una petición ajax --}}
                    <select name="usuario_asignado" id="usuario"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        <template x-for="usuario in usuarios" :key="usuario.id">
                            <option :value="usuario.id" x-text="usuario.nombre"
                                :selected="usuario.id === {{ old('usuario_asignado', $incidencia->usuario_asignado) }}">
                            </option>
                        </template>
                    </select>
                </div>

                <div>
                    <x-input-label for="ubicacion" :value="__('Ubicación')" />
                    <select name="ubicacion_id" id="ubicacion"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id }}"
                                {{ old('ubicacion_id', $incidencia->ubicacion_id) === $ubicacion->id ? 'selected' : '' }}>
                                {{ $ubicacion->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="ubicacionError"></div>

                </div>

                <div>
                    <x-input-label for="categoria" :value="__('Categoría')" />

                    <select name="categoria_id" id="categoria"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ old('categoria_id', $incidencia->categoria_id) === $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="categoriaError"></div>


                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">{{ old('descripcion', $incidencia->descripcion) }}</textarea>
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1" id="descripcionError"></div>
                </div>
            </div>

            <div class="relative h-32 flex flex-row items-center justify-center">
                <a href="{{ route('incidencias.show', $incidencia) }}" class="absolute left-3 py-2 mt-2 ">
                    <svg class="h-11 hover:scale-110" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                        <path fill="#000000"
                            d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160zm352-160l-160 160c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L301.3 256 438.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0z" />
                    </svg>
                </a>



                <input type="submit" value="Guardar incidencia"
                    class="cursor-pointer bg-black hover:bg-gray-700 text-white font-bold w-48 py-3 mt-2 mb-2 rounded" />


            </div>



        </form>
    </section>

    <script>
        /* Realiza una petición ajax a una funcion del controlador de user que devuelve al seleccionar un departamento, los usuarios del mismo
            para mostrarlos en el select de usuario asignado. */
        function usuariosComponent() {
            return {
                // Inicializamos las propiedades del componente
                usuarios: [],
                // Utilizamos json para convertir el valor de Blade a JSON
                departamentoId: @json(old('departamento_id', $incidencia->departamento_id)),


                // Función para cargar usuarios al cambiar el departamento
                async cargarUsuarios() {
                    // Realizamos una petición fetch utilizando el valor del departamentoId
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
