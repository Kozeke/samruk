@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-blog-2.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        <div class="search">
            <form class="search__form form-panel" method="get" action="{{ route('site.search') }}">
                <div class="search__form-title">{{ $section->name }}</div>

                <div class="search__form-field">
                    {{ Form::text('query', request()->input('query'), [
                        'class' => 'input search__form-input',
                        'placeholder' => trans('translations.search.placeholder'),
                        'autocomplete' => 'off',
                        'autocorrect' => 'off'
                    ])
                }}
                    <button class="search__form-submit btn btn--secondary" type="submit">
                        {!! __('translations.search.button') !!}
                    </button>
                </div>
            </form>

            @if (request()->input('query'))
                <div class="search__count formatted">
                    @if (app()->getLocale() == 'ru')
                        По запросу <span>{{ request()->input('query') }}</span>
                        @php
                            pluralForm(
                                $records->total(),
                                /* варианты написания для количества 1, 2 и 5 */
                                array('найден', 'найдено', 'найдено'),
                                array('материал', 'материала', 'материалов')
                            );
                        @endphp
                    @endif

                    @if (app()->getLocale() == 'kz')
                        <span>{{ request()->input('query') }}</span> сұрау бойынша {{ $records->total() }} материал табылды
                    @endif

                    @if (app()->getLocale() == 'en')
                        On request <span>{{ request()->input('query') }}</span>
                        @php
                            pluralForm(
                                $records->total(),
                                /* варианты написания для количества 1, 2 и 5 */
                                array('found', 'found', 'found'),
                                array('material', 'material', 'materials')
                            );
                        @endphp
                    @endif
                </div>

                @if ($records->count())
                    <ul class="search__result">
                        @foreach ($records as $record)
                            <li class="post-text">
                                <div class="post-text__meta">
                                    <time
                                        class="post-text__date"
                                        datetime="{{ date('Y-m-d', strtotime($record->published_at)) }}"
                                    >{{ date('d.m.Y', strtotime($record->published_at)) }}</time>
                                </div>

                                <a class="post-text__link link" href="{{ $record->url }}">
                                    <h3 class="post-text__title">
                                        {{ str_limit(strip_tags($record->title ?? $record->short ?? $record->full)) }}
                                    </h3>
                                </a>

                                @if ($record->short || $record->full)
                                    <div class="post-text__description formatted">
                                        @if ($record->short)
                                            {!! str_limit(strip_tags($record->short), 400) !!}
                                        @else
                                            {!! str_limit(strip_tags($record->full), 400) !!}
                                        @endif
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    @include('site.blocks.snippets.pagination')
                @endif
            @endif
        </div>

    @endcomponent
@endsection
