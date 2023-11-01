<x-app-layout>
    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto relative mt-4">
        <table class="mx-auto text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th scope="col" class="py-3 px-6">Nombre</th>
                <th scope="col" class="py-3 px-6">Telefono</th>
                <th scope="col" class="py-3 px-6">Email</th>
                <th scope="col" class="py-3 px-6">Curriculum</th>
            </thead>
            <tbody>

                @foreach ($aspirantes as $aspirante)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6"><a
                                href="{{ route('aspirantes.show', $aspirante) }}">{{ $aspirante->nombre . " " . $aspirante->primer_apellido . " " . $aspirante->segundo_apellido }}</a>
                        </td>

                        <td class="py-4 px-6">
                            {{ $aspirante->telefono}}
                        </td>

                        <td class="py-4 px-6">
                            {{ $aspirante->email}}
                        </td>

                        <td>
                            <a href="{{ route('descargar.pdf', $aspirante->id) }}">
                                <i class="fas fa-file-pdf"></i> Descargar PDF
                            </a>
                        </td>

                        <td class="px-6 text-center">
                            <form action="{{ route('aspirantes.destroy', $aspirante) }}" method="POST" class="inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Borrar</button>
                            </form>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</x-app-layout>
