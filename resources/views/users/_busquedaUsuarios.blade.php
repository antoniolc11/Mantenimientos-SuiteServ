@if ($usuarios->isEmpty())
<tr>
    <td colspan="6" class="h-full">
        <div class="flex items-center justify-center h-full mt-6 mb-6">
            <p class="text-center font-bold text-gray-800">No hay aspirantes aún</p>
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
