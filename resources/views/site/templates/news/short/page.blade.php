@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'section' => $section->parent,
        'introPageBgUrl' => '/site/img/redesign/intro/intro-news.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        <div class="title-page-wrap">
            <h2 class="title-page">{{ $section->name }}</h2>
            @include('site.blocks.snippets.btn-docs')
        </div>

        @if ($records->count())
            @php
                $record = $records->first();
                $files = $record->media('file')->where('lang', app()->getLocale())->orderBy('sind', 'desc')->get();
                $videos = $record->videos()->where('lang', app()->getLocale())->orderBy('sind', 'desc')->get();
            @endphp

            @if ($record->short || $record->full)
                <div class="formatted formatted--mb">
                    {!! $record->short !!}
                    {!! $record->full !!}
                </div>
            @endif

            @include('site.templates.news.blocks.videos')
            @include('site.templates.news.blocks.files')
        @else
            @include('site.blocks.snippets.filling')
        @endif

    @endcomponent
@endsection



