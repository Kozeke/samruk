<section class="section activities" id="activities" data-jarallax>
    <img class="jarallax-img lazy" src="" data-src="/site/img/redesign/common/bg-activities-2.jpg" alt="">

    <div class="container">
        <div class="activities__header">
            <h2 class="activities__title title-section" data-aos="fade-right" data-aos-delay="200">
                <strong>{{ count($links) }}</strong>
                {{ $section->name }}
            </h2>

            @foreach ($links as $link)
                @if ($link->class === 'intro')
                    <div class="activities__description" data-aos="fade-right" data-aos-delay="400">
                        {!! strip_tags($link->description) !!}
                    </div>

                    {{--<div class="activities__more" data-aos="fade-right" data-aos-delay="600">
                        <a class="btn btn--secondary" href="{{ $link->link }}" {!! $link->target !!}>
                            {{ __('translations.more') }}
                        </a>
                    </div>--}}
                @endif
            @endforeach
        </div>

        <div class="activities__list">
            @php $aosDelay = 0; @endphp

            @foreach ($links as $link)
                @if ($link->class !== 'intro')
                    @php $aosDelay += 100; @endphp

                    <div class="activities__item" data-aos="fade-up" data-aos-delay="{{ $aosDelay }}">
                        <a class="activities__item-link link" href="{{ $link->link }}" {!! $link->target !!}>
                            @if ($link->class)
                                <span class="activities__item-icon">{!! icon($link->class) !!}</span>
                            @endif
                            <span class="activities__item-text">{{ $link->title }}</span>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
