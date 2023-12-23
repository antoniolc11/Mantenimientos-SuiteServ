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
                {{-- imagen y Menú desplegable --}}
                <div class="md:w-1/2 flex justify-end pl-4 relative">
                    <div class="flex flex-col relative">
                        {{-- Imagen del usuario --}}
                        <div>
                            <img class="h-48 w-48 border-2 border-black rounded-t" id="imgPerfil"
                                src="{{ $usuario->fotoperfil ? Storage::url($usuario->fotoperfil) : 'https://mastermdi.com/files/students/noImage.jpg' }}"
                                alt="usuario avatar" />
                        </div>
                        {{-- Boton de editar la imagen que abre el menú desplegable --}}
                        <div class="relative group">
                            <button
                                class="text-default flex items-center justify-center cursor-pointer bg-black hover:bg-gray-700 text-white w-full p-0.5 rounded-b">
                                <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                                    data-view-component="true"
                                    class="octicon octicon-pencil fill-current text-white mr-1">
                                    <path fill="#fff"
                                        d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251.93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                                    </path>
                                </svg>
                                Editar
                            </button>
                            @include('users.partials.desplegableEditImage')
                        </div>
                    </div>
                </div>
            </div>
            {{-- Botón para editar el perfil del usuario. --}}
            <div class="w-full mt-4 text-center mb-5">
                <a href="{{ route('users.edit', $usuario) }}"><button
                        class="cursor-pointer bg-black hover:bg-gray-700 text-white font-bold w-32 py-3 rounded"
                        type="submit">Editar perfil</button>
            </div>
        </div>
    </div>
</x-app-layout>
