@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-photo.jpg'
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
                @include('site.blocks.snippets.post-gallery', ['images' => $items])
                @include('site.blocks.snippets.page-back')
            </div>
        </article>

    @endcomponent
@endsection
