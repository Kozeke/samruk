@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-invest-4.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        @if ($records->count())
            <div class="posts-list">
                @php $aosDelay = 0; @endphp

                @foreach ($records as $record)
                    @php $aosDelay += 100; @endphp

                    @include('site.blocks.snippets.post-card', ['record' => $record, 'aosDelay' => $aosDelay])
                @endforeach
            </div>

            @include('site.blocks.snippets.pagination')
        @else
            @include('site.blocks.snippets.filling')
        @endif

    @endcomponent
@endsection

