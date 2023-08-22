@if (count($links))
    <div class="about-history">
        @foreach ($links as $link)
            <div class="about-history__item">
                <div class="about-history__item-title">{{ $link->title }}</div>
                <div class="about-history__item-description">{!! $link->description !!}</div>
            </div>
        @endforeach
    </div>
@endif
