@if (isset($record))
    <div class="post-card" data-aos="fade-up" data-aos-delay="{{ $aosDelay }}">
        @php $cover = $record->media->first(); @endphp

        <a class="post-card__image-wrap ratio" href="{{ $record->url }}">
            @if (!is_null($cover))
                <img class="lazy" src="/image/resize/568/370/{{ $cover->link }}" alt="{{ $record->title }}">
            @else
                <img class="lazy" src="/site/img/redesign/common/no-image.png" alt="{{ $record->title }}">
            @endif
            <span class="post-card__image-overlay">{!! icon('icon--skcn') !!}</span>
        </a>

        <div class="post-card__info">
            <div class="post-card__meta">
                <time class="post-card__date" datetime="{{ date('Y-m-d', strtotime($record->published_at)) }}">
                    {{ date('d.m.Y', strtotime($record->published_at)) }}
                </time>
            </div>

            <a class="link" href="{{ $record->url }}">
                <h3 class="post-card__title">{{ $record->title }}</h3>
            </a>
        </div>
    </div>
@endif
