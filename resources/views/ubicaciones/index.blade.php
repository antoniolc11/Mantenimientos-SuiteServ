<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ubicaciones') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="h-9">
                {{-- Mostrar los mensajes de exito. --}}
                @if (session('success'))
                    <x-success-alert :status="session('success')" />
                    <?php session()->forget('success'); ?>
                @endif

                {{-- Mostrar los mensajes de error. --}}
                @if (session('error'))
                    <x-error-alert :messages="session('error')" />
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-gray-900 dark:text-gray-100">
                    @if (auth()->user()->esDepartamentoDireccion())
                        <div class="flex justify-end p-2">
                            <button type="button"
                                class="bg-neutral-800 hover:bg-gray-700 text-white font-bold w-32 py-3 rounded"
                                data-modal-target="defaultModal" data-modal-toggle="defaultModal" Toggle modal>
                                Nuevo
                            </button>
                        </div>
                    @endif
                    <table id="tablaubicacions" class="min-w-full text-feft text-sm font-light ">
                        <thead
                            class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                            <tr>
                                <th scope="col" class=" px-6 py-4">Ubicaciones</th>
                                <th scope="col" class=" px-6 py-4">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Aquí va tu estructura de tabla para mostrar los ubicaciones -->
                            @foreach ($ubicaciones as $ubicacion)
                                <tr class="border-b dark:border-neutral-500 hover:bg-gray-200">
                                    <td class="whitespace-nowrap  px-6 py-4">
                                        {{ $ubicacion->nombre }}
                                    </td>
                                    <td class="px-6 text-center">
                                        <button type="button"
                                            class="cursor-pointer bg-neutral-800 hover:bg-gray-700 text-white font-bold w-16 py-1 rounded"
                                            data-modal-target="modalEdit{{ $ubicacion->id }}"
                                            data-modal-toggle="modalEdit{{ $ubicacion->id }}">

                                            Editar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed bottom-0 left-0 w-full bg-gray-200 p-4">
        <div class="mx-auto max-w-screen-md">
            {{ $ubicaciones->links('components.paginate') }}
        </div>
    </div>

    <!-- Ventana modal para crear un nuevo ubicacion -->
    @include('ubicaciones.create')

    @foreach ($ubicaciones as $ubicacion)
        <!-- Ventana modal para editar un ubicacion -->
        @include('ubicaciones.edit')
    @endforeach

</x-app-layout>
