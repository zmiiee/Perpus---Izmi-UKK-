@if ($paginator->hasPages())
    <ul class="list-unstyled d-flex align-items-center gap-2 mb-0 pagination-common-style">
        {{-- Tombol Previous --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><a href="javascript:void(0);"><i class="bi bi-arrow-left"></i></a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}"><i class="bi bi-arrow-left"></i></a></li>
        @endif

        {{-- Elemen Halaman --}}
        @foreach ($elements as $element)
            {{-- String "Separator" (Titik-titik) --}}
            @if (is_string($element))
                <li><a href="javascript:void(0);"><i class="bi bi-dot"></i></a></li>
            @endif

            {{-- Array Link Angka --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a href="javascript:void(0);" class="active">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Tombol Next --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}"><i class="bi bi-arrow-right"></i></a></li>
        @else
            <li class="disabled"><a href="javascript:void(0);"><i class="bi bi-arrow-right"></i></a></li>
        @endif
    </ul>
@endif