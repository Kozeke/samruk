@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-default.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        @if ($records->count())
            <div class="row">
                @foreach ($records as $record)
                    <div class="leader-card col-12 col-md-6 col-xl-4">
                        <a class="leader-card__link" href="{{ $record->url }}">
                            <div class="leader-card__image-wrap ratio" href="{{ $record->url }}">
                                @if (!is_null($record->media->first()))
                                    <img
                                        class="lazy"
                                        src=""
                                        data-src="/image/resize/366/404/{{ $record->media->first()->link }}"
                                        alt="{{ $record->title }}"
                                    >
                                @endif
                            </div>

                            <div class="leader-card__info">
                                <h3 class="leader-card__title">{{ $record->title }}</h3>
                                <div class="leader-card__desc">{!! strip_tags($record->short, '<p>') !!}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @include('site.blocks.snippets.pagination')
        @else
            @include('site.blocks.snippets.filling')
        @endif

    @endcomponent
@endsection



