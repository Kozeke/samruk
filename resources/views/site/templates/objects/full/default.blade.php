@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-projects.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page', ['showAside' => false])

        @php $images = $object->images(); @endphp

        <article class="post post--object">
            <div class="post__main">
                <div class="post__info {{ $images->count() ? '' : 'w-100 pr-0' }}">
                    <h2 class="post__title">{{ $object->title }}</h2>

                    <div class="post__subtitle formatted">
                        <p>
                            <b>{{ __('objects.program') }}:</b>
                            {{ __('objects.programs.' . $object->program) }}
                        </p>

                        <p>
                            <b>{{ __('objects.type') }}:</b>
                            <span class="text-capitalize">{{ __('objects.types.' . $object->type) }}</span>
                        </p>
                    </div>
                </div>

                @include('site.templates.news.blocks.images')
            </div>

            <div class="post__content">
                <div class="accordion">
                    @if ($object->about)
                        <div class="accordion__item is-active">
                            <div class="accordion__head">
                                <div class="accordion__head-toggle" data-accordion>{{ __('objects.about') }}</div>
                            </div>

                            <div class="accordion__body">
                                <div class="accordion__content formatted">{!! $object->about !!}</div>
                            </div>
                        </div>
                    @endif

                    @if ($object->infrastructure)
                        <div class="accordion__item">
                            <div class="accordion__head">
                                <div class="accordion__head-toggle" data-accordion>
                                    {{ __('objects.infrastructure') }}
                                </div>
                            </div>

                            <div class="accordion__body">
                                <div class="accordion__content formatted">{!! $object->infrastructure !!}</div>
                            </div>
                        </div>
                    @endif

                    @if ($object->plans)
                        <div class="accordion__item">
                            <div class="accordion__head">
                                <div class="accordion__head-toggle" data-accordion>{{ __('objects.plans') }}</div>
                            </div>

                            <div class="accordion__body">
                                <div class="accordion__content formatted">{!! $object->plans !!}</div>
                            </div>
                        </div>
                    @endif

                    @if ($object->circs)
                        <div class="accordion__item">
                            <div class="accordion__head">
                                <div class="accordion__head-toggle" data-accordion>{{ __('objects.circs') }}</div>
                            </div>

                            <div class="accordion__body">
                                <div class="accordion__content formatted">{!! $object->circs !!}</div>
                            </div>
                        </div>
                    @endif

                    @if ($object->developer)
                        <div class="accordion__item">
                            <div class="accordion__head">
                                <div class="accordion__head-toggle" data-accordion>{{ __('objects.developer') }}</div>
                            </div>

                            <div class="accordion__body">
                                <div class="accordion__content formatted">{!! $object->developer !!}</div>
                            </div>
                        </div>
                    @endif

                    @if ($object->location)
                        <div class="accordion__item">
                            <div class="accordion__head">
                                <div class="accordion__head-toggle" data-accordion>{{ __('objects.location') }}</div>
                            </div>

                            <div class="accordion__body">
                                <div class="accordion__content formatted">{!! $object->location !!}</div>
                            </div>
                        </div>
                    @endif
                </div>

                @include('site.blocks.snippets.page-back')
            </div>
        </article>

    @endcomponent
@endsection
