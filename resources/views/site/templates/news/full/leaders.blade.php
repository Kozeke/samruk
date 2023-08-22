@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-default.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        <article class="leader">
            <div class="leader__main">
                <div class="leader__main-left">
                    <div class="leader__image-wrap ratio">
                        @php $image = $images->count() ? $images->first() : null; @endphp

                        @if (!is_null($image))
                            <img
                                class="lazy"
                                src=""
                                data-src="/image/resize/380/410/{{ $image->link }}"
                                alt="{{ $data->title }}"
                            >
                        @endif
                    </div>
                </div>

                <div class="leader__main-right">
                    <h2 class="leader__title">{{ $data->title }}</h2>

                    @if ($data->short)
                        <div class="leader__subtitle">{!! strip_tags($data->short, '<p>') !!}</div>
                        <div class="leader__description formatted">{!! strip_tags($data->short, '<p>') !!}</div>
                    @endif
                </div>
            </div>

            <div class="leader__body">
                <div class="leader__content formatted">{!! $data->full !!}</div>

                @include('site.templates.news.blocks.videos')
                @include('site.templates.news.blocks.files')
            </div>
        </article>

    @endcomponent
@endsection

