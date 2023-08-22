@if (count($links))
    <section class="section partners">
        <div class="container">
            <div class="partners__slider swiper js-partners-slider" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper-wrapper">
                    @foreach ($links as $link)
                        @if ($link->photo)
                            <div class="partners__slide swiper-slide">
                                @if ($link->link === '#')
                                    <img
                                        src=""
                                        class="swiper-lazy"
                                        data-src="/{{ $link->photo }}"
                                        width="100" height="100"
                                        alt="{{ $link->title }}"
                                    >
                                    <div class="swiper-lazy-preloader"></div>
                                @else
                                    <a href="{{ $link->link }}" target="_blank">
                                        <img
                                            src=""
                                            class="swiper-lazy"
                                            data-src="/{{ $link->photo }}"
                                            width="100" height="100"
                                            alt="{{ $link->title }}"
                                        >
                                        <div class="swiper-lazy-preloader"></div>
                                    </a>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
