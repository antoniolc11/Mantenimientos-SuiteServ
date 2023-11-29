<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Estados') }}
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
                    <table id="tablaEstados" class="min-w-full text-feft text-sm font-light ">
                        <thead
                            class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                            <tr>
                                <th scope="col" class=" px-6 py-4">Estados</th>
                                <th scope="col" class=" px-6 py-4">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Aquí va tu estructura de tabla para mostrar los estados -->
                            @foreach ($estados as $estado)
                                <tr class="border-b dark:border-neutral-500">
                                    <td class="whitespace-nowrap  px-6 py-4">
                                        {{ $estado->nombre }}
                                    </td>
                                    <td class="px-6 text-center">
                                        <button type="button"
                                            class="cursor-pointer bg-neutral-800 hover:bg-gray-700 text-white font-bold w-16 py-1 rounded"
                                            data-modal-target="modalEdit{{ $estado->id }}"
                                            data-modal-toggle="modalEdit{{ $estado->id }}">

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

    <!-- Ventana modal para crear un nuevo estado -->
    @include('estados.create')

    @foreach ($estados as $estado)
        <!-- Ventana modal para editar un estado -->
        @include('estados.edit')
    @endforeach

</x-app-layout>
