@if ($paginator->hasPages())
    <div class="pagination">
        <div class="pagination__inner">
            @if ($paginator->onFirstPage())
                <a class="_item arrow arrow-left" disabled=""><i></i></a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="_item arrow arrow-left"><i></i></a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="_item dots">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="_item current">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="_item">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="_item arrow arrow-right"><i></i></a>
            @else
                <a class="_item arrow arrow-right" disabled=""><i></i></a>
            @endif
        </div>
    </div>
@endif