@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-faq.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        @if ($records->count())
            <ul class="faq-list">
                @foreach ($records as $record)
                    <li class="faq-item is-active">
                        <h4 class="faq-item__title">{{ $record->title }}</h4>

                        <div class="faq-item__body">
                            <div class="faq-item__content formatted">
                                <blockquote>
                                    {!! $record->short !!}
                                    {!! $record->full !!}
                                </blockquote>
                            </div>
                        </div>

                        {{--<button
                            class="faq-item__toggle btn btn--primary"
                            data-text-open="{{ __('translations.answer') }}"
                            data-text-close="{{ __('translations.hideAnswer') }}"
                        >{{ __('translations.hideAnswer') }}</button>--}}
                    </li>
                @endforeach
            </ul>

            @include('site.blocks.snippets.pagination')
        @else
            @include('site.blocks.snippets.filling')
        @endif

    @endcomponent
@endsection


