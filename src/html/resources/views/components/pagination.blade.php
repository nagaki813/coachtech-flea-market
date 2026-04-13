@if ($paginator->hasPages())
    <div class="custom-pagination">
        @if ($paginator->onFirstPage())
            <span class="pagination-btn disabled">‹ 前へ</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn">
                ‹ 前へ
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pagination-ellipsis">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pagination-number active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn">
                次へ ›
            </a>
        @else
            <span class="pagination-btn disabled">次へ ›</span>
        @endif
    </div>
@endif