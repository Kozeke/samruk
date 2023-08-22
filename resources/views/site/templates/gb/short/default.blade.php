@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-blog.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        @include('site.templates.gb.blocks.gb-form')
        @include('site.blocks.snippets.pagination')

    @endcomponent
@endsection
