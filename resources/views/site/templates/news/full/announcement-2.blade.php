@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-announcement-2.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page', ['showAside' => false])

        <article class="post">
            <div class="post__main">
                <div class="post__info w-100 pr-0">
                    <div class="post__meta">
                        <div class="post__date">
                            {!! icon('icon--time') !!}
                            <time datetime="{{ date('Y-m-d', strtotime($data->published_at)) }}">
                                {{ date('d.m.Y', strtotime($data->published_at)) }}
                            </time>
                        </div>
                    </div>

                    <h2 class="post__title">{{ $data->title }}</h2>
                </div>
            </div>

            <div class="post__content post__content--wide">
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
