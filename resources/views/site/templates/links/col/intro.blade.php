@if (count($links))
    <section class="section intro" id="intro">
        <div class="intro__slider swiper js-intro-slider">
            <div class="swiper-wrapper">
                @foreach ($links as $link)
                    <div class="intro__slider-slide swiper-slide">
                        @if ($link->photo)
                            <div class="swiper-lazy" data-background="/{{ $link->photo }}">
                                <div class="swiper-lazy-preloader"></div>
                            </div>
                        @endif

                        <div class="intro__slider-content container-sm">
                            <h2
                                class="intro__slider-title"
                                data-aos="fade-right"
                                data-aos-delay="200"
                            >{{ $link->title }}</h2>

                            <p
                                class="intro__slider-text"
                                data-aos="fade-right"
                                data-aos-delay="400"
                            >{!! strip_tags($link->description) !!}</p>

                            <div class="intro__slider-more" data-aos="fade-right" data-aos-delay="600">
                                <a class="btn btn--secondary" href="{{ $link->link }}" {!! $link->target !!}>
                                    {{ __('translations.more') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
        </div>
    </section>
@endif
