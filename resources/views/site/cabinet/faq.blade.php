@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page-cabinet')
@endsection

@section('content')
<section class="section cabinet">
    <div class="cabinet__inner container" data-aos="fade-up" data-aos-delay="200">
        @include('site.cabinet.snippets.header')

        <div class="cabinet__main">
            <h2 class="title-page">Часто задаваемые вопросы</h2>
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
        </div>

        <aside class="cabinet__aside">
        </aside>
    </div>
</section>
@endsection
