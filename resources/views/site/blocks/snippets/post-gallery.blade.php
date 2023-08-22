@if ($images->count())
    <div class="post-gallery">
        @foreach ($images as $image)
            @if ($image->link)
                <div class="post-gallery__item">
                    <a class="post-gallery__link" href="/{{ $image->link }}" data-glightbox>
                        <div class="post-gallery__image-wrap ratio">
                            <img class="lazy" src="" data-src="/image/resize/400/270/{{ $image->link }}" alt="">
                        </div>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
@endif
