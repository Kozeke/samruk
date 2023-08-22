@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-development.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        @php $colPageText = getPage('promyshlennye-i-infrastrukturnye-obekty-desc'); @endphp

        @if ($colPageText)
            <div class="formatted formatted--mb">{!! $colPageText !!}</div>
        @endif

        @if ($records->count())
            <div class="posts-list">
                @php $aosDelay = 0; @endphp

                @foreach ($records as $record)
                    @php $aosDelay += 100; @endphp

                    @include('site.blocks.snippets.post-card', ['record' => $record, 'aosDelay' => $aosDelay])
                @endforeach
            </div>

            @include('site.blocks.snippets.pagination')
        @endif

    @endcomponent
@endsection

