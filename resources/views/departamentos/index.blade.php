<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Departamentos') }}
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
                    <table id="tablaDepartamentos" class="min-w-full text-feft text-sm font-light ">
                        <thead
                            class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                            <tr>
                                <th scope="col" class=" px-6 py-4">Departamentos</th>
                                <th scope="col" class=" px-6 py-4">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Aquí va tu estructura de tabla para mostrar los departamentos -->
                            @foreach ($departamentos as $departamento)
                                <tr class="border-b dark:border-neutral-500 hover:bg-gray-200">
                                    <td class="whitespace-nowrap  px-6 py-4">
                                        {{ $departamento->nombre }}
                                    </td>
                                    <td class="px-6 text-center">
                                        <button type="button"
                                            class="cursor-pointer bg-neutral-800 hover:bg-gray-700 text-white font-bold w-16 py-1 rounded"
                                            data-modal-target="modalEdit{{ $departamento->id }}"
                                            data-modal-toggle="modalEdit{{ $departamento->id }}">

                                            Editar
                                        </button>

                                        <button type="submit"
                                            class="cursor-pointer bg-neutral-800 hover:bg-gray-700 text-white font-bold w-16 py-1 rounded"
                                            data-modal-toggle="popup-modal{{ $departamento->id }}">Borrar</button>
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
            {{ $departamentos->links('components.paginate') }}
        </div>
    </div>

    <!-- Ventana modal para crear un nuevo departamento -->
    @include('departamentos.create')

    @foreach ($departamentos as $departamento)
        <!-- Ventana modal para editar un departamento -->
        @include('departamentos.edit')

        {{-- Ventana modal para borrar al departamento --}}
        <div id="popup-modal{{ $departamento->id }}" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 ">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-black bg-transparent  hover:text-gray-500 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-toggle="popup-modal{{ $departamento->id }}">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                    <div class="p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 512 512" aria-hidden="true" class="mx-auto mb-4 w-10 h-10 text-red-400 dark:text-gray-200"
                            fill="#ff0000" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <!--!Font Awesome Free 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path fill="#d20404" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-black  dark:text-gray-400">¿Seguro que desea borrar
                            este
                            departamento?</h3>
                        <form action="{{ route('departamentos.destroy', $departamento) }}" method="POST"
                            class="inline">
                            @method('DELETE')
                            @csrf

                            <button data-modal-toggle="popup-modal{{ $departamento->id }}" type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                Sí, seguro
                            </button>
                            <button data-modal-toggle="popup-modal{{ $departamento->id }}" type="button"
                                class="text-black  bg-white hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No,
                                cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</x-app-layout>
