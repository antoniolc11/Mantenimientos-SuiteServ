        <!-- Ventana modal para editar un estado -->
        <div id="modalReasigmaniento{{ $usuarios }}_{{ $incidencia->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative  w-96 max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-1 border-b rounded-t dark:border-gray-600 bg-black">
                        <button type="button"
                            class="text-white bg-transparent  hover:text-gray-400 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="modalReasigmaniento{{ $usuarios }}_{{ $incidencia->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('reasignar.incidencia', $incidencia) }}" method="POST">
                        @method('put')
                        @csrf
                        <div class="p-6 space-y-6 text-center">
                            <select name="usuario" id="usuario"
                                class="w-full border p-2 rounded appearance-none focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent px-3 py-2 leading-tight focus:shadow-outline">
                                @foreach ($usuarios as $usuario)
                                    @if ($usuario->status === 1)
                                        <option {{ $incidencia->usuario_asignado == $usuario->id ? 'selected' : '' }}
                                            value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex items-center justify-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <!-- Botón "Crear" -->
                            <button type="submit"
                                class="cursor-pointer bg-green-600 hover:bg-gray-700 text-white font-bold w-24 py-2 rounded">Guardar</button>

                            <!-- Espacio entre botones -->
                            <div class="w-4"></div>

                            <!-- Botón "Cancelar" -->
                            <button data-modal-hide="modalReasigmaniento{{ $usuarios }}_{{ $incidencia->id }}"
                                type="button"
                                class="cursor-pointer bg-red-600 hover:bg-gray-700 text-white font-bold w-24 py-2 rounded">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
