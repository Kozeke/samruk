@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-about-2.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page', ['showAside' => false])

        {!! getPage('istoriya-kompanii', 'about-history'); !!}

        {!! getLinks('col-about-history', 'about-history') !!}

        @if (!empty($text))
            <div class="formatted formatted--secondary">{!! $text !!}</div>
        @endif

        @include('site.blocks.snippets.page-back')

    @endcomponent
@endsection
