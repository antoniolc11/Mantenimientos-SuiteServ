<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Aspirantes') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">



            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">


                @if (session('success'))
                    <div class="bg-green-200 text-green-800 p-4 mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <table id="tablaAspirantes" class="min-w-full text-center text-sm font-light">
                        <thead
                            class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                            <tr>
                                <th scope="col" class=" px-6 py-4">Nif</th>
                                <th scope="col" class=" px-6 py-4">Nombre</th>
                                <th scope="col" class=" px-6 py-4">Telefono</th>
                                <th scope="col" class=" px-6 py-4">Email</th>
                                <th scope="col" class=" px-6 py-4">Curriculum</th>
                                <th scope="col" class=" px-6 py-4">Opción</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if ($aspirantes->isEmpty())
                            <tr>
                                <td colspan="6" class="h-full">
                                    <div class="flex items-center justify-center h-full mt-6">
                                        <p class="text-center font-bold text-gray-800">No hay aspirantes aún</p>
                                    </div>
                                </td>
                            </tr>
                            @else
                                <!-- Aquí va tu estructura de tabla para mostrar los aspirantes -->
                                @foreach ($aspirantes as $aspirante)
                                    <tr class="border-b dark:border-neutral-500">
                                        <td class="whitespace-nowrap  px-6 py-4 font-medium"><a
                                                href="{{ route('aspirantes.show', $aspirante) }}">{{ $aspirante->nif }}</a>
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">
                                            <a
                                                href="{{ route('aspirantes.show', $aspirante) }}">{{ $aspirante->nombre . ' ' . $aspirante->primer_apellido . ' ' . $aspirante->segundo_apellido }}</a>
                                        </td>
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">
                                            {{ substr($aspirante->telefono, 0, 3) }}
                                            {{ substr($aspirante->telefono, 3, 3) }}
                                            {{ substr($aspirante->telefono, 6) }}
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">{{ $aspirante->email }}</td>
                                        <td>
                                            <a href="{{ Storage::url($aspirante->curriculum) }}" target="_blank">
                                                <i class="fas fa-file-pdf"></i> Descargar el Curriculum
                                            </a>
                                        </td>
                                        <td class="px-6 text-center">

                                            <form action="{{ route('aspirantes.destroy', $aspirante) }}" method="POST"
                                                class="inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" >
                                                    <img src="{{ asset('imagenes/boton-x.png') }}" alt="Icono"
                                                        class="w-6 h-6 mr-2 inline max-w-xs transition duration-300 ease-in-out hover:-scale-x-125" />
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
