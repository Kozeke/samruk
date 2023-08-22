@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-invest-2.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        @if ($images->count() || !empty($text))
            @include('site.blocks.snippets.post-gallery')

            @if (!empty($text))
                <div class="formatted">{!! $text !!}</div>
            @endif
        @else
            @include('site.blocks.snippets.filling')
        @endif

        @include('site.blocks.snippets.page-back')

    @endcomponent
@endsection

