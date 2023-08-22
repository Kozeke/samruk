@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-media.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        @if ($records->count())
            <div class="posts-list">
                @php $aosDelay = 0; @endphp

                @foreach ($records as $record)
                    @php $video = $record->videos()->whereLang(app()->getLocale())->whereGood(1)->first(); @endphp

                    @if ($video)
                        @php $aosDelay += 100; @endphp

                        <div class="post-card" data-aos="fade-up" data-aos-delay="{{ $aosDelay }}">
                            <a
                                class="post-card__link"
                                href="https://www.youtube.com/watch?v={{ getCodeVideo($video->link) }}&rel=0"
                                data-glightbox
                            >
                                <div class="post-card__image-wrap ratio">
                                    <img src="//img.youtube.com/vi/{{ getCodeVideo($video->link) }}/hqdefault.jpg" alt="">
                                    {!! icon('icon--youtube-play', 'post-card__icon-play') !!}
                                </div>

                                <div class="post-card__info">
                                    <div class="post-card__meta">
                                        <time
                                            class="post-card__date"
                                            datetime="{{ date('Y-m-d', strtotime($record->published_at)) }}"
                                        >{{ date('d.m.Y', strtotime($record->published_at)) }}</time>
                                    </div>

                                    <h3 class="post-card__title">{{ $video->title }}</h3>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

            @include('site.blocks.snippets.pagination')
        @else
            @include('site.blocks.snippets.filling')
        @endif

    @endcomponent
@endsection



