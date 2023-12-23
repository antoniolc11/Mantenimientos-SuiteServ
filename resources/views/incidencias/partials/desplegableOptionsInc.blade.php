<div x-data="{ isOpen: false }" class="relative">
    <button @click="isOpen = !isOpen" type="button" aria-label="More options" title="More options" tabindex="0"
        class="types__StyledButton-sc-ws60qy-0 bcAPvy mb-9" x-ref="button">
        <svg aria-hidden="true" focusable="false" role="img" class="octicon octicon-kebab-horizontal"
            viewBox="0 0 16 16" width="16" height="16" fill="currentColor"
            style="display:inline-block;user-select:none;vertical-align:text-bottom;overflow:visible">
            <path
                d="M8 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM1.5 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm13 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z">
            </path>
        </svg>
    </button>
    <ul x-show="isOpen" @click.away="isOpen = false" class="absolute border mt-2 rounded shadow-lg bg-gray-100 p-1"
        x-cloak x-transition:enter="transition-transform ease-out duration-300 transform"
        x-transition:enter-start="scale-75" x-transition:leave="transition-transform ease-in duration-300 transform"
        x-transition:leave-end="scale-75"
        :style="{
            top: $refs.button ? ($refs.button.offsetTop + $refs.button.offsetHeight - 2) +
                'px' : 'auto',
            left: $refs.button ? 'auto' : '0', // Deja la izquierda como 'auto' para que se ajuste al contenido
            right: $refs.button ? ($refs.button.offsetLeft + $refs.button.offsetWidth - 8) +
                'px' : 'auto',
            'margin-top': '-2px',
            'width': 'max-content'
        }">
        <!-- Contenido del menú desplegable -->

        {{-- TODO: barajar la opción de cerrar incidencia directamente --}}
        @if ($incidencia->estado_id != 3)
            @if (auth()->user()->esDepartamentoDireccion() ||
                    auth()->user()->esDepartamentosupervision())
                <li class="text-black w-full p-1 hover:bg-gray-200 font-normal text-start">
                    <a href="{{ route('incidencias.edit', $incidencia) }}">Editar</a>
                </li>


                <button type="submit" class="text-black w-full p-1 hover:bg-gray-200 font-normal text-start"
                    data-modal-target="modalReasigmaniento{{ $usuarios }}_{{ $incidencia->id }}"
                    data-modal-toggle="modalReasigmaniento{{ $usuarios }}_{{ $incidencia->id }}">Reasignar
                </button>
            @endif


            <li class="text-black w-full p-1 hover:bg-gray-200 font-normal text-start">
                <button type="submit" data-modal-toggle="cerrar-modal{{ $incidencia->id }}">Pasar a
                    resuelta</button>
            </li>

        @endif



        @if ($incidencia->estado_id == 3)
            <li class="text-black w-full p-1 hover:bg-gray-200 font-normal text-start">
                <button type="submit" data-modal-toggle="reabrir-modal{{ $incidencia->id }}">Reabrir</button>
            </li>
            <li class="text-black w-full p-1 hover:bg-gray-200 font-normal">
                <a href="{{ route('generate-pdf', $incidencia) }}" target="_blank" class="btn btn-primary">
                    <button data-modal-hide="defaultModal" type="button">Parte
                        de trabajo</button>
                </a>
            </li>
        @endif
        <!-- Agregar más elementos al desplegable según sea necesario -->
    </ul>
</div>

<!-- Ventana modal para confirmar cerrar una incidencia -->
@include('incidencias.partials.cerrarIncConfirm')
<!-- Ventana modal para confirmar reabrir una incidencia -->
@include('incidencias.partials.reabrirConfirm')
<!-- Ventana modal para reasignar la incidencia a otro usuario -->
@include('incidencias.partials.modalReasignamiento')
