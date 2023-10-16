@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" 
                        href="{{ $paginator->nextPageUrl() }}" 
                        rel="next">Next</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            {{-- show in to --}}
            <div>
                <ul class="pagination">

                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previousText')">
                            <span class="page-link" href="{{ $paginator->url(1) }}">@lang('pagination.previousText')</span>
                        </li>
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">@lang('pagination.previous')</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{$paginator->url(1)}}" >@lang('pagination.previousText')</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">@lang('pagination.previous')</a>
                        </li>
                    @endif
                    @php
                    $startPage = 1;
                    $endPage = 5;

                    if($paginator->currentPage() > 4) {
                        if($paginator->currentPage() > $paginator->lastPage() - 4) {
                            $startPage = $paginator->lastPage() - 4;
                        } else {
                            $startPage = $paginator->currentPage() - 2;
                        }
                    } else {
                        $startPage = 1;
                    }

                    $endPage = $startPage + 4;  
                    @endphp
                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- Array Of Links --}}
                        @if (is_array($element))
                        @foreach ($element as $page => $url)
                                @if ($paginator->currentPage() > 4 && $page === 1)
                                    <li class="page-item "><a class="page-link" href="?page={{ $paginator->currentPage() - 4 < 1 ? 1 : $paginator->currentPage() - 4 }}">...</a></li>
                                @endif   
                               @if(($page >= $startPage && $page <= $endPage))
                                    @if ($page == $paginator->currentPage())
                                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                    @elseif($page <= $endPage)
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endif
                                @if ($paginator->currentPage() <= $paginator->lastPage() - 4 && $page === $paginator->lastPage())
                                    <li class="page-item"><a class="page-link" href="?page={{ $paginator->currentPage() + 5 > $paginator->lastPage() ? $paginator->lastPage() : $paginator->currentPage() + 5 }}">...</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">@lang('pagination.next')</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{$paginator->url($paginator->lastPage())}}" rel="next" aria-label="@lang('pagination.nextText')">@lang('pagination.nextText')</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">@lang('pagination.next')</span>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" rel="next" aria-label="@lang('pagination.nextText')">@lang('pagination.nextText')</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
