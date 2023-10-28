<x-app-layout>
    <div class="overflow-x-auto relative mt-4">
        <table class="mx-auto text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th scope="col" class="py-3 px-6">Operarios</th>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6"><a href="{{route('users.show', $usuario)}}">{{ $usuario->nombre }}</a></td>


                        <td class="px-6 text-center">
                            <a href="{{ route('users.edit',  ['user' => $usuario]) }}"><button class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Editar</button></a>
                            <form action="{{ route('users.destroy', $usuario) }}" method="POST" class="inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Borrar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-end py-3 px-16 " >
                            <a href="{{ route('users.create') }}"><button class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Añadir operario</button></a>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>

</x-app-layout>
