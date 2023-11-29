<x-app-layout>


    <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-20">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Nueva orden de incidencia</h2>

        <form action="{{ route('incidencias.store') }}" method="POST" x-data="usuariosComponent()">
            @csrf {{-- agrega el campo oculto con el token (si no ponemos esto no valdrá el envio del formulario) --}}

            {{-- Pasa el dato del usuario que crea la incidencia, que será el id del usuario logado. --}}
            <input type="hidden" name="usuario_creador" value="{{ auth()->user()->id }}">

            {{-- El estado por defecto será el estado_id = 1 que pertenece a "Pendiente" --}}
            <input type="hidden" name="estado_id" value="1">


            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <div>
                    <x-input-label for="prioridad" :value="__('Prioridad')" />
                    <select name="prioridad" id="prioridad"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">

                        <option value="Alta" {{ old('prioridad') === 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Media" {{ old('prioridad') === 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Baja" {{ old('prioridad') === 'Baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>

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
                </div>

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

                <div>
                    <x-input-label for="ubicacion" :value="__('Ubicación')" />
                    <select name="ubicacion_id" id="ubicacion"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="categoria" :value="__('Categoría')" />

                    <select name="categoria_id" id="categoria"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent">
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                        class="'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent"></textarea>
                </div>
            </div>

            <div class="flex justify-center">
                <input type="submit" value="Generar incidencia"
                class="cursor-pointer bg-black hover:bg-gray-700 text-white font-bold w-48 py-3 mt-14 mb-2 rounded" />

            </div>

        </form>
    </section>

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

</x-app-layout>
