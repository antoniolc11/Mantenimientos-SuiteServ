@forelse ($incidencias as $incidencia)
    <!-- Tu código para mostrar cada incidencia -->
    <tr class="border-b dark:border-neutral-500 hover:bg-gray-200">
        <td class="whitespace-nowrap  px-6 py-4 font-medium"><a
                href="{{ route('incidencias.show', $incidencia) }}">{{ $incidencia->numero }}</a>
        </td>
        <td class="whitespace-nowrap  px-6 py-4 text-center"><span
                class="h-5 w-5 inline-block rounded-full {{ $incidencia->prioridadColor() }}"></span>
        </td>
        <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->categoria->nombre }}
        </td>
        <td class="whitespace-nowrap  px-6 py-4">{{ \Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y') }}
        </td>
        <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->departamento->nombre }}
        </td>
        <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->creador->nombre }}
        </td>
        @if (auth()->user()->esDepartamentoDireccion() ||
                auth()->user()->esDepartamentosupervision())
            <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->asignado->nombre }}
            </td>
        @endif
        <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->estado->nombre }}</td>
        <td class="whitespace-nowrap  px-6 py-4">{{ $incidencia->ubicacion->nombre }}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="h-full">
            <div class="flex items-center justify-center h-full mt-6 mb-6">
                <p class="text-center font-bold text-gray-800">No hay incidencias que mostrar</p>
            </div>
        </td>
    </tr>
@endforelse



