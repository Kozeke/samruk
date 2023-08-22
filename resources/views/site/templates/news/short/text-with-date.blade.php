@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page')
@endsection

@section('content')
    @component('site.component.page')

        @if ($records->count())
            <ul>
                @foreach ($records as $record)
                    <li class="post-text">
                        <div class="post-text__meta">
                            <time
                                class="post-text__date"
                                datetime="{{ date('Y-m-d', strtotime($record->published_at)) }}"
                            >{{ date('d.m.Y', strtotime($record->published_at)) }}</time>
                        </div>

                        <a class="post-text__link link" href="{{ $record->url }}">
                            <h3 class="post-text__title">{{ $record->title }}</h3>
                        </a>
                    </li>
                @endforeach
            </ul>

            @include('site.blocks.snippets.pagination')
        @else
            @include('site.blocks.snippets.filling')
        @endif

    @endcomponent
@endsection



