@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center items-center mt-6 space-x-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 bg-gray-200 text-gray-500 rounded cursor-not-allowed text-center w-[120px] opacity-50"><-Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded text-center w-[120px]">
                <-Previous
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded text-center w-[120px]">
                Next->
            </a>
        @else
            <span class="px-4 py-2 bg-gray-200 text-gray-500 rounded cursor-not-allowed text-center w-[120px] opacity-50">Next-></span>
        @endif
    </nav>
@endif
