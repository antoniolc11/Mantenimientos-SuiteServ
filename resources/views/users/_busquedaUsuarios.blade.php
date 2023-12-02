@if ($usuarios->isEmpty())
    <tr>
        <td colspan="6" class="h-full">
            <div class="flex items-center justify-center h-full mt-6 mb-6">
                <p class="text-center font-bold text-gray-800">No hay usuarios aún</p>
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
            <td>

                {{-- Botón para editar el perfil del usuario. --}}
                <div class="w-full text-center">
                    <a href="{{ route('users.edit', $usuario) }}">
                        <button title="Editar" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700"
                                viewBox="0 0 512 512">
                                <path
                                    d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                            </svg>
                        </button>
                    </a>
                    @if ($usuario->status == 1)
                                        {{-- Botón para editar el perfil del usuario. --}}
                    <a href="{{ route('users.addbanned', $usuario) }}">
                        <button title="Bloquear" type="submit" class="ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700"
                                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path fill="#ff0000"
                                    d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                            </svg>
                        </button>
                    </a>
                    @else
                    {{-- Botón para editar el perfil del usuario. --}}
                    <a href="{{ route('users.outbanned', $usuario) }}">
                        <button title="Desbloquear" class="ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="hover:scale-110 h-6 w-6 text-green-500 hover:text-green-700" viewBox="0 0 448 512">
                                <path fill="#1b5e0d"
                                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                            </svg>
                        </button>
                    </a>
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
@endif
