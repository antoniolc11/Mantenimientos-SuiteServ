<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Aspirantes') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif


    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">



            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">



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
                            </tr>
                        </thead>

                        <tbody x-html="resultados">

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
                                    <td class="whitespace-nowrap  px-6 py-4">{{ substr($aspirante->telefono, 0, 3) }} {{ substr($aspirante->telefono, 3, 3) }} {{ substr($aspirante->telefono, 6) }}
                                    </td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $aspirante->email }}</td>
                                    <td>
                                        <a href="{{ Storage::url($aspirante->curriculum); }}" target="_blank">
                                            <i class="fas fa-file-pdf"></i> Descargar el Curriculum
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
