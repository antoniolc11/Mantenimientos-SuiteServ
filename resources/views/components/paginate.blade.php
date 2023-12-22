@if ($paginator->hasPages())
    <div class="flex flex-col items-center">
        <!-- Help text -->

        <span class="text-sm text-gray-700 dark:text-gray-400">
            Mostrando
            <span class="font-semibold text-gray-900 dark:text-white">
                {{ $paginator->firstItem() }}
            </span>
            a
            <span class="font-semibold text-gray-900 dark:text-white">
                {{ $paginator->lastItem() }}
            </span>
            de
            <span class="font-semibold text-gray-900 dark:text-white">
                {{ $paginator->total() }}
            </span>
            Entradas
        </span>
        <!-- Buttons -->
        <div class="inline-flex mt-2 xs:mt-0">
            @if ($paginator->onFirstPage())
                <button class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-500 rounded-l cursor-not-allowed" disabled>
                    Anterior
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Anterior
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-s border-gray-700 rounded-e hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                Siguiente
                </a>
            @else
                <button class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-500 rounded-e cursor-not-allowed" disabled>
                    Siguiente
                </button>
            @endif
        </div>
    </div>
@endif
