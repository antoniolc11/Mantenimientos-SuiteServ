<x-app-layout>
    <div class="py-12 mt-16">
        <div class="overflow-hidden shadow-sm sm:rounded-lg  max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white">
            <div class="rounded py-7 px-12 bg-white w-full flex flex-wrap">
                {{-- Datos del usuario --}}
                <div class="w-full md:w-1/2 flex flex-col pr-4"> <!-- Añadir clase pr-4 para el margen derecho -->
                    <h2 class="text-xl font-semibold" style="text-decoration: underline; solid black;">Datos personales
                    </h2>

                    <p class="text-gray-700 mt-8">Nombre: <span class="font-bold">{{ $usuario->nombre }}</span></p>
                    <p class="text-gray-700 mt-4">Apellidos: <span class="font-bold">
                            {{ $usuario->primer_apellido . ' ' . $usuario->segundo_apellido }}</span></p>
                    <p class="text-gray-700 mt-4">Email: <span class="font-bold">{{ $usuario->email }}</span></p>
                    <p class="text-gray-700 mt-4">Telefono: <span class="font-bold">
                            {{ substr($usuario->telefono, 0, 3) }}
                            {{ substr($usuario->telefono, 3, 3) }}
                            {{ substr($usuario->telefono, 6) }}</span></p>

                    <p class="text-gray-700 mt-4">Departamento: <span class="font-bold">

                            {{ $usuario->departamentos->implode('nombre', ', ') }}




                        </span></p>
                    <p class="text-gray-700 mt-4 mb-9">Nif: <span class="font-bold">{{ $usuario->nif }}</span></p>
                </div>

                <div class="md:w-1/2 flex justify-end pl-4 relative">
                    <div class="flex flex-col relative">
                        {{-- Imagen del usuario --}}
                        <div>
                            <img class="h-48 w-48 border-2 border-black rounded-t" id="imgPerfil"
                                src="{{$usuario->fotoperfil ? Storage::url($usuario->fotoperfil) : 'https://st3.depositphotos.com/4111759/13425/v/1600/depositphotos_134255588-stock-illustration-empty-photo-of-male-profile.jpg' }}"
                                alt="usuario avatar" />
                        </div>

                        {{-- Boton para modificar la imagen del usuario. --}}
                        <div class="relative group form-group">
                            <form action="{{ route('user.editar.foto', $usuario) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label
                                    class=" text-default flex items-center justify-center cursor-pointer bg-black hover:bg-gray-700 text-white w-full p-0.5 rounded-b"
                                    for="editarImagen">
                                    <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1"
                                        width="16" data-view-component="true"
                                        class="octicon octicon-pencil fill-current text-white mr-1">
                                        <path fill="#fff"
                                            d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251.93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                                        </path>
                                    </svg>
                                    Editar</label>
                                <input name="imagen" class="hidden" type="file" id="editarImagen" accept="image/*">
                                <button id="guardarImagen"
                                    class="absolute hidden bg-black border text-white border-gray-300 rounded mt-0 space-y-2"
                                    type="submit">Guardar</button>
                            </form>



                            @if ($usuario->fotoperfil)
                                <form action="{{ route('user.borrar.foto', $usuario) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button id="borrarImagen"
                                        class="absolute bg-black border text-white border-gray-300 rounded mt-0 space-y-2"
                                        type="submit">Eliminar foto</button>
                                </form>
                            @endif

                            {{-- Fin Menú desplegable --}}
                        </div>
                    </div>
                </div>


                <!-- Script para controlar la visibilidad del menú desplegable para editar o borrar la foto de perfíl -->
                <script>
                    const imgPerfil = document.querySelector('#imgPerfil');
                    const editarImagen = document.querySelector('#editarImagen');
                    const defaulFile = imgPerfil.src;
                    const guardarImagen = document.querySelector('#guardarImagen')
                    editarImagen.addEventListener('change', (e) => {
                        if (e.target.files[0] != undefined) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                imgPerfil.src = e.target.result;
                            }
                            reader.readAsDataURL(e.target.files[0]);
                            guardarImagen.classList.remove('hidden');
                            borrarImagen.classList.add('hidden');
                        } else {
                            imgPerfil.src = defaulFile;
                            guardarImagen.classList.add('hidden');
                            borrarImagen.classList.remove('hidden');
                        }
                    });



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
                </script>

                {{-- Botón para editar el perfil del usuario. --}}
                <div class="w-full mt-4 text-center">
                    <a href="{{ route('users.edit', $usuario) }}"><button
                            class="cursor-pointer bg-black hover:bg-gray-700 text-white font-bold w-32 py-3 rounded"
                            type="submit">Editar perfil</button>
                </div>
            </div>
        </div>



</x-app-layout>
