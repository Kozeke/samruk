@php $aosDelay = 100; @endphp

@foreach ($links as $link)
    @php $aosDelay += 100; @endphp

    <div class="footer__info" data-aos="fade-up" data-aos-delay="{{ $aosDelay }}">
        <h3 class="footer__info-title">{{ $link->title }}</h3>

        <div class="footer__info-body">{!! $link->description !!}</div>

        @if ($link->class === 'map')
            <div class="footer__info-bottom">
                <a
                    class="btn btn--secondary btn--size-sm"
                    href="/{{ app()->getLocale() }}/page/kontakty"
                >{{ __('translations.onTheMap') }}</a>
            </div>
        @endif

        @if ($loop->last)
            <div class="footer__info-bottom">
                {!! __('translations.footer.dev') !!}
            </div>
        @endif
    </div>
@endforeach
