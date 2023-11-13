<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Operarios') }}
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
                <div class="mr-6 ml-6 text-gray-900 dark:text-gray-100">

                    @if (auth()->user()->esDepartamentoDireccion() ||
                            auth()->user()->esDepartamentosupervision())
                        <div class="flex justify-end p-2">
                            <a href="{{ route('users.create') }}">
                                <input type="submit" value="Nuevo usuario"
                                    class="cursor-pointer bg-black hover:bg-gray-700 text-white font-bold w-32 py-3 rounded" />
                            </a>
                        </div>
                    @endif

                    <table id="tablaUsers" class="min-w-full text-center text-sm font-light">
                        <thead
                            class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                            <tr>
                                <th scope="col" class=" px-6 py-4">Nif</th>
                                <th scope="col" class=" px-6 py-4">Nombre</th>
                                <th scope="col" class=" px-6 py-4">Telefono</th>
                                <th scope="col" class=" px-6 py-4">Email</th>
                            </tr>
                        </thead>

                        <tbody x-html="resultados">

                            @if ($usuarios->isEmpty())
                                <tr>
                                    <td colspan="6" class="h-full">
                                        <div class="flex items-center justify-center h-full mt-6">
                                            <p class="text-center font-bold text-red-500">No hay usuarios aún</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                <!-- Aquí va tu estructura de tabla para mostrar los usuarios -->
                                @foreach ($usuarios as $usuario)
                                    <tr class="border-b dark:border-neutral-500">
                                        <td class="whitespace-nowrap  px-6 py-4 font-medium"><a
                                                href="{{ route('users.show', $usuario) }}">{{ $usuario->nif }}</a>
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4 text-left">
                                            <a
                                                href="{{ route('users.show', $usuario) }}">{{ $usuario->nombre . ' ' . $usuario->primer_apellido . ' ' . $usuario->segundo_apellido }}</a>
                                        </td>
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">
                                            {{ substr($usuario->telefono, 0, 3) }}
                                            {{ substr($usuario->telefono, 3, 3) }}
                                            {{ substr($usuario->telefono, 6) }}
                                        </td>
                                        <td class="whitespace-nowrap  px-6 py-4">{{ $usuario->email }}</td>
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
