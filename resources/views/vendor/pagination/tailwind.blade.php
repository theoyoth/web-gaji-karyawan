@if ($paginator->hasPages())
	<nav class="flex justify-center items-center gap-1 my-4">
		{{-- Previous --}}
		@if ($paginator->onFirstPage())
			<span class="px-3 py-1 text-gray-400">← Prev</span>
		@else
			<a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 text-white bg-zinc-800 rounded hover:underline">← Prev</a>
		@endif

		{{-- Page numbers --}}
		@foreach ($elements as $element)
			@if (is_string($element))
				<span class="px-3 py-1 text-gray-500">{{ $element }}</span>
			@endif

			@if (is_array($element))
				@foreach ($element as $page => $url)
					@if ($page == $paginator->currentPage())
						<span class="px-3 py-1 border border-zinc-800 text-zinc-800 rounded">{{ $page }}</span>
					@else
						<a href="{{ $url }}" class="px-3 py-1 border-zinc-800 hover:underline">{{ $page }}</a>
					@endif
				@endforeach
			@endif
		@endforeach

		{{-- Next --}}
		@if ($paginator->hasMorePages())
			<a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 text-white bg-zinc-800 rounded hover:underline">Next →</a>
		@else
			<span class="px-3 py-1 text-gray-400">Next →</span>
		@endif
	</nav>

@endif
