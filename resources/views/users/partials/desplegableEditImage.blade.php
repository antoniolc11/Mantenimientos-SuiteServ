                            {{-- Menú desplegable --}}
                            <div
                                class="absolute hidden bg-black border text-white border-gray-300 rounded mt-0 space-y-2">
                                <div class="form-group">
                                    {{-- Boton para modificar la imagen del usuario. --}}
                                    <div class="relative group form-groupw w-48">
                                        <form action="{{ route('user.editar.foto', $usuario) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label
                                                class=" text-default flex items-center justify-center cursor-pointer bg-gray-800 hover:bg-gray-700 text-white w-full p-0.5"
                                                for="editarImagen">
                                                Añadir nueva</label>
                                            <input name="imagen" class="hidden" type="file" id="editarImagen"
                                                accept="image/*">
                                            <button id="guardarImagen"
                                                class="absolute hidden bg-gray-800 hover:bg-gray-700 border text-white border-gray-300 rounded mt-0 space-y-2 w-full"
                                                type="submit">Guardar</button>
                                        </form>

                                        @if ($usuario->fotoperfil)
                                            <form action="{{ route('user.borrar.foto', $usuario) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button id="borrarImagen"
                                                    class=" text-default flex items-center justify-center cursor-pointer bg-gray-800 hover:bg-gray-700 text-white w-full p-0.5 rounded-b"
                                                    type="submit">Eliminar foto</button>
                                            </form>
                                        @endif

                                        {{-- Fin Menú desplegable --}}
                                    </div>
                                </div>
                            </div>
                            {{-- Fin Menú desplegable --}}
                            <!-- Script para controlar la visibilidad del menú desplegable para editar o borrar la foto de perfíl -->
                            <script>
                                //Abre el desplegable de editar la imagen.
                                document.addEventListener('DOMContentLoaded', function() {
                                    const dropdownButton = document.querySelector('.group');
                                    const dropdownMenu = document.querySelector('.group .absolute');

                                    dropdownButton.addEventListener('click', function() {
                                        dropdownMenu.classList.toggle('hidden');
                                    });

                                    // Cerrar el menú si se hace clic fuera de él
                                    window.addEventListener('click', function(event) {
                                        if (!dropdownButton.contains(event.target)) {
                                            dropdownMenu.classList.add('hidden');
                                        }
                                    });
                                });



                                // Obtén la referencia del elemento de imagen y el input de editar imagen
                                const imgPerfil = document.querySelector('#imgPerfil');
                                const editarImagen = document.querySelector('#editarImagen');

                                // Almacena la ruta predeterminada de la imagen
                                const defaulFile = imgPerfil.src;

                                // Obtén la referencia al botón de guardar imagen
                                const guardarImagen = document.querySelector('#guardarImagen');

                                // Agrega un evento de escucha al cambio en el input de editar imagen
                                editarImagen.addEventListener('change', (e) => {
                                    // Verifica si se ha seleccionado un archivo
                                    if (e.target.files[0] != undefined) {
                                        // Crea un objeto FileReader para leer el archivo
                                        const reader = new FileReader();

                                        // Cuando se completa la lectura, actualiza la fuente de la imagen
                                        reader.onload = (e) => {
                                            imgPerfil.src = e.target.result;
                                        }

                                        // Lee el contenido del archivo como una URL de datos
                                        reader.readAsDataURL(e.target.files[0]);

                                        // Muestra el botón de guardar y oculta el botón de borrar
                                        guardarImagen.classList.remove('hidden');
                                        borrarImagen.classList.add('hidden');
                                    } else {
                                        // Si no se selecciona ningún archivo, restaura la imagen predeterminada
                                        imgPerfil.src = defaulFile;

                                        // Oculta el botón de guardar y muestra el botón de borrar
                                        guardarImagen.classList.add('hidden');
                                        borrarImagen.classList.remove('hidden');
                                    }
                                });
                            </script>
