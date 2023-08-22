@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-projects.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        <div class="projects">
            <form
                class="projects-filter form-panel"
                action="{{ route('site.objects.index', ['alias' => $request->alias]) }}"
                method="get"
            >
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="form-group">
                            <label class="form-group__label">{{ __('objects.city') }}</label>

                            <div class="form-group__input">
                                <div class="select">
                                    {{ Form::select('rubric', $rubrics, $request->input('rubric'), ['placeholder' => __('objects.all_city') , 'class' => '']) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="form-group">
                            <div class="form-group__label">{{ __('objects.program') }}</div>

                            <div class="form-group__input">
                                @foreach (trans('objects.programs') as $program => $programValue)
                                    <div class="form-check">
                                        <label class="form-check__label">
                                            <input
                                                type="radio"
                                                name="program"
                                                value="{{ $program }}"
                                                {{ ($request->input('program') === $program) ? 'checked' : '' }}
                                            >
                                            <span>{{ $programValue }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="form-group">
                            <div class="form-group__label">{{ __('objects.type') }}</div>

                            <div class="form-group__input">
                                @foreach (trans('objects.types') as $type => $typeValue)
                                    <div class="form-check projects-filter__type-wrap">
                                        <label class="form-check__label">
                                            <input
                                                type="radio"
                                                name="type"
                                                value="{{ $type }}"
                                                {{ ($request->input('type') == $type) ? 'checked' : '' }}
                                            >
                                            <span class="text-capitalize">{{ $typeValue }}</span>
                                        </label>

                                        <i class="projects-filter__type projects-filter__type--{{ $type }}"></i>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-12">
                        <div class="projects-filter__actions">
                            <a
                                class="btn btn--outline-secondary"
                                href="{{ route('site.objects.index', ['alias' => $request->alias]) }}"
                            >{{ __('objects.reset') }}</a>
                            {{ Form::submit(trans('objects.view'), ['class' => 'btn btn--secondary']) }}
                        </div>
                    </div>
                </div>
            </form>

            @if ($records->count())
                <div class="projects__list row">
                    @foreach ($records as $record)
                        <div class="project-card project-card--type-{{ $record->type }} col-12 col-md-6 col-xl-4">
                            <a class="project-card__link" href="{{ $record->url }}">
                                <div class="project-card__image-wrap ratio">
                                    @if ($record->cover())
                                        <img
                                            class="lazy"
                                            src=""
                                            data-src="/image/resize/366/252/{{ $record->cover() }}"
                                            alt=""
                                        >
                                    @endif
                                </div>

                                <h3 class="project-card__title">{{ $record->title }}</h3>
                            </a>
                        </div>
                    @endforeach
                </div>

                @include('site.blocks.snippets.pagination')
            @endif
        </div>

    @endcomponent
@endsection
