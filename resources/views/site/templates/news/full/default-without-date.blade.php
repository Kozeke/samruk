@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-news.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page', ['showAside' => false])

        <article class="post">
            <div class="post__main">
                <div class="post__info {{ $images->count() ? '' : 'w-100 pr-0' }}">
                    <h2 class="post__title">{{ $data->title }}</h2>
                </div>

                @include('site.templates.news.blocks.images')
            </div>

            <div class="post__content">
                <div class="post__description formatted">
                    {!! $data->short !!}
                    {!! $data->full !!}
                </div>

                @include('site.templates.news.blocks.videos')
                @include('site.templates.news.blocks.files')
                @include('site.blocks.snippets.page-back')
            </div>
        </article>

    @endcomponent
@endsection
