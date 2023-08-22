@if (count($links))
    <div class="about__slider swiper js-about-slider">
        <div class="swiper-wrapper">
            @foreach ($links as $link)
                <div class="swiper-slide">
                    <div class="about__slider-number">{!! strip_tags($link->description) !!}</div>
                    <h3 class="about__slider-title">{{ $link->title }}</h3>
                </div>
            @endforeach
        </div>

        <div class="swiper-pagination"></div>
    </div>
@endif
