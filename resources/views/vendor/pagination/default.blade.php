@if ($paginator->hasPages())
    <div class="pagination" data-aos="fade-up" data-aos-delay="200">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <div class="pagination__arrow pagination__arrow--prev">
                <a class="pagination__arrow-link"
                   href="{{ $paginator->previousPageUrl() }}"
                   title="{{ trans('translations.page_prev') }}">
                    {!! icon('icon--arrow', 'icon--arrow-left') !!}
                </a>
            </div>
        @endif

        <ul class="pagination__list">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="pagination__item is-disabled">
                        <span class="pagination__link is-disabled">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination__item is-active">
                                <span class="pagination__link is-active">{{ $page }}</span>
                            </li>
                        @else
                            <li class="pagination__item">
                                <a class="pagination__link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <div class="pagination__arrow pagination__arrow--right">
                <a class="pagination__arrow-link"
                   href="{{ $paginator->nextPageUrl() }}"
                   title="{{ trans('translations.page_next') }}">
                    {!! icon('icon--arrow', 'icon--arrow-right') !!}
                </a>
            </div>
        @endif
    </div>
@endif
