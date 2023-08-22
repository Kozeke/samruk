@if ($images->count())
    <div class="post__images swiper js-post-images">
        <div class="swiper-wrapper">
            @foreach ($images as $image)
                @if ($image->link)
                    <div class="post__images-slide swiper-slide">
                        <a
                            class="swiper-lazy"
                            href="/{{ $image->link }}"
                            data-glightbox data-background="/image/resize/690/450/{{ $image->link }}"
                        >
                            <div class="swiper-lazy-preloader"></div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>

        @if ($images->count() > 1)
            <div class="swiper-button-prev">{!! icon('icon--arrow', 'icon--arrow-left') !!}</div>
            <div class="swiper-button-next">{!! icon('icon--arrow', 'icon--arrow-right') !!}</div>
        @endif
    </div>
@endif
