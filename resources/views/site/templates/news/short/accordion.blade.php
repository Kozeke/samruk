@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-news.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        @if ($records->count())
            <div class="accordion mb-0">
                @foreach ($records as $record)
                    <div class="accordion__item">
                        <div class="accordion__head">
                            <div class="accordion__head-toggle" data-accordion>
                                {{ $record->title }}
                            </div>
                        </div>

                        <div class="accordion__body">
                            <div class="accordion__content formatted">
                                {!! $record->short !!}
                                {!! $record->full !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @include('site.blocks.snippets.pagination')
        @else
            @include('site.blocks.snippets.filling')
        @endif

    @endcomponent
@endsection



