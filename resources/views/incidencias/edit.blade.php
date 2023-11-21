<x-app-layout>


    <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-20">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Editar orden de incidencia</h2>

        <form id="formulario" action="{{ route('incidencias.update', $incidencia) }}" method="POST" x-data="usuariosComponent({{ old('departamento_id', $incidencia->departamento_id) }})">
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

                        <option value="Alta" {{ old('prioridad', $incidencia->prioridad) === 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Media" {{ old('prioridad', $incidencia->prioridad) === 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Baja" {{ old('prioridad', $incidencia->prioridad) === 'Baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="departamento" :value="__('Departamento')" />
                    <select name="departamento_id" id="departamento" x-model="departamentoId"
                        x-init="cargarUsuarios()"
                        x-on:change="cargarUsuarios()"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id }}" {{ old('departamento_id', $incidencia->departamento_id) === $departamento->id ? 'selected' : '' }}>{{ $departamento->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="usuario_asignado" :value="__('Usuario')" />
                    {{-- Carga automáticamente los usuarios que pertenecen al departamento seleccionado anteriormente,
                        a través de una petición ajax --}}
                    <select name="usuario_asignado" id="usuario"
                            class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        <template x-for="usuario in usuarios" :key="usuario.id">
                            <option :value="usuario.id" x-text="usuario.nombre" :selected="usuario.id === {{ old('usuario_asignado', $incidencia->usuario_asignado) }}"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <x-input-label for="ubicacion" :value="__('Ubicación')" />
                    <select name="ubicacion_id" id="ubicacion"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id }}" {{ old('ubicacion_id', $incidencia->ubicacion_id) === $ubicacion->id ? 'selected' : '' }}>{{ $ubicacion->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="categoria" :value="__('Categoría')" />

                    <select name="categoria_id" id="categoria"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $incidencia->categoria_id) === $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">{{  old('descripcion', $incidencia->descripcion) }}
                    </textarea>
                </div>
            </div>

            <div class="flex justify-center">
                <input type="submit" value="Guardar cambios"
                    class="bg-black text-white font-bold text-lg hover:bg-gray-700 py-2 mt-8  px-2 w-56" />
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
                    console.log(this.departamentoId);
                    console.log("entra");
                    // Realizamos una petición fetch utilizando el valor del departamentoId
                    if (this.departamentoId) {
                        console.log("existe");

                        const response = await fetch(`/usuarios-por-departamento/${this.departamentoId}`);
                        this.usuarios = await response.json();
                    } else {
                        this.usuarios = [];
                    }
                }
            };
        }

    </script>

</x-app-layout>
