{{--@if ($paginator->hasPages())--}}
    {{--<ul class="pagination">--}}
        {{-- Previous Page Link --}}
        {{--@if ($paginator->onFirstPage())--}}
            {{--<li class="disabled"><span>&laquo;</span></li>--}}
        {{--@else--}}
            {{--<li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>--}}
        {{--@endif--}}

        {{-- Pagination Elements --}}
        {{--@foreach ($elements as $element)--}}
            {{-- "Three Dots" Separator --}}
            {{--@if (is_string($element))--}}
                {{--<li class="disabled"><span>{{ $element }}</span></li>--}}
            {{--@endif--}}

            {{-- Array Of Links --}}
            {{--@if (is_array($element))--}}
                {{--@foreach ($element as $page => $url)--}}
                    {{--@if ($page == $paginator->currentPage())--}}
                        {{--<li class="active"><span>{{ $page }}</span></li>--}}
                    {{--@else--}}
                        {{--<li><a href="{{ $url }}">{{ $page }}</a></li>--}}
                    {{--@endif--}}
                {{--@endforeach--}}
            {{--@endif--}}
        {{--@endforeach--}}

        {{-- Next Page Link --}}
        {{--@if ($paginator->hasMorePages())--}}
            {{--<li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>--}}
        {{--@else--}}
            {{--<li class="disabled"><span>&raquo;</span></li>--}}
        {{--@endif--}}
    {{--</ul>--}}
{{--@endif--}}


@if($paginator->hasPages())
<ul class="pagination" role="navigation" aria-label="Pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <li class="pagination-previous disabled">Anterior <span class="show-for-sr">página</span></li>
    @else
        <li class="pagination-previous"><a href="{{ $paginator->previousPageUrl() }}">Anterior <span class="show-for-sr">página</span></a></li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="disabled"><span>{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())

                    <li class="current"><span class="show-for-sr">Você está na página</span> {{ $page }}</li>
                @else
                    <li><a href="{{ $url }}" aria-label="Page {{$page}}">{{$page}}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="pagination-next"><a href="{{ $paginator->nextPageUrl() }}" aria-label="Next page">Próxima <span class="show-for-sr">página</span></a></li>
    @else
        <li class="pagination-next disabled">Próxima <span class="show-for-sr">página</span></li>
    @endif
</ul>
@endif()