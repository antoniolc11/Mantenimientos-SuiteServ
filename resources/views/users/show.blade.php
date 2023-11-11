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

                <div class="md:w-1/2 flex justify-end pl-4 ">
                    {{-- Imagen del usuario --}}
                    <div class="flex flex-col ">
                        <div>
                            <img class="h-48 w-48 border-2 border-black rounded-md"
                                src="{{ asset('imagenes/personal.jpeg') }}" alt="usuario avatar" />
                        </div>
                        {{-- Botón de editar perfil fuera del contenedor de la imagen --}}
                        <div class="w-full mt-4 text-center">


                                <a href="{{ route('users.edit', $usuario) }}"><button
                                    class="cursor-pointer bg-black hover:bg-gray-700 text-white font-bold w-32 py-3 rounded"
                                    type="submit">Editar perfil</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
