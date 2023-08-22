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



