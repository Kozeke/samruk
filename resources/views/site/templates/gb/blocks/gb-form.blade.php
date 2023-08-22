<div class="faq">
    <div class="faq__header">
        <h2 class="faq__header-title title-page">
            {{ __('translations.gb.ask_question') }}
        </h2>

        <a class="faq__header-toggle btn btn--primary {{ $errors->any() || session()->has('success') ? 'is-active' : '' }}"
           data-collapse="#faq-form" href="javascript:;">
            {{ __('translations.gb.ask_question') }}
        </a>
    </div>

    <form
        class="faq-form"
        id="faq-form"
        method="post"
        @if ($errors->any() || session()->has('success'))
            style="display: block;"
        @else
            style="display: none;"
        @endif
    >
        {!! csrf_field(); !!}

        <div class="row">
            @if (session()->has('success'))
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="alert alert--success mb-0">{{ session('success') }}</div>
                </div>
            @else
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {{ Form::label('name', __('translations.gb.name'), ['class' => 'form-group__label']) }}

                        <div class="form-group__input">
                            {{ Form::text('name', null, ['class' => 'input', 'id' => 'name']) }}
                        </div>

                        @if ($errors->has('name'))
                            <div class="form-group__error">{!! $errors->first('name') !!}</div>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                        {{ Form::label('surname', __('translations.gb.surname'), ['class' => 'form-group__label']) }}

                        <div class="form-group__input">
                            {{ Form::text('surname', null, ['class' => 'input', 'id' => 'surname']) }}
                        </div>

                        @if ($errors->has('surname'))
                            <div class="form-group__error">{!! $errors->first('surname') !!}</div>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {{ Form::label('email', __('translations.gb.email'), ['class' => 'form-group__label']) }}

                        <div class="form-group__input">
                            {{ Form::text('email', null, ['class' => 'input', 'id' => 'email']) }}
                        </div>

                        @if ($errors->has('email'))
                            <div class="form-group__error">{!! $errors->first('email') !!}</div>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-12">
                    <div class="form-group{{ $errors->has('theme') ? ' has-error' : '' }}">
                        {{ Form::label('theme', __('translations.gb.theme'), ['class' => 'form-group__label']) }}

                        <div class="form-group__input">
                            {{ Form::text('theme', null, ['class' => 'input', 'id' => 'theme']) }}
                        </div>

                        @if ($errors->has('theme'))
                            <div class="form-group__error">{!! $errors->first('theme') !!}</div>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-12 col-xl-12">
                    <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                        {{ Form::label('message', __('translations.gb.text_question'), ['class' => 'form-group__label']) }}

                        <div class="form-group__input">
                            {{ Form::textarea('message', null, ['class' => 'textarea', 'id' => 'message']) }}
                        </div>

                        @if ($errors->has('message'))
                            <div class="form-group__error">{!! $errors->first('message') !!}</div>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-12 col-xl-12">
                    <div class="form-group text-right mb-0">
                        {{ Form::submit(__('translations.gb.send'), ['class' => 'faq-form__submit btn btn--secondary']) }}
                    </div>
                </div>
            @endif
        </div>
    </form>

    @if (isset($records) && $records->count())
        <ul class="faq-list">
            @foreach ($records as $record)
                <li class="faq-item">
                    <div class="faq-item__meta">
                        <time class="faq-item__date"
                              datetime="{{ date('Y-m-d', strtotime($record->published_at)) }}">
                            {{ date('d.m.Y', strtotime($record->published_at)) }}
                        </time>

                        <div class="faq-item__name">
                            {{ __('translations.gb.question') }}
                            {{ $record->name }} {{ $record->surname }}
                        </div>
                    </div>

                    <div class="faq-item__title">
                        {!! $record->message !!}
                    </div>

                    <div class="faq-item__body">
                        <div class="faq-item__content formatted">
                            <blockquote>
                                <p class="faq-item__content-label">
                                    {{ __('translations.gb.answer') }}
                                </p>
                                {!! $record->answer !!}
                            </blockquote>
                        </div>
                    </div>

                    <button
                        class="faq-item__toggle btn btn--primary"
                        data-text-open="{{ __('translations.answer') }}"
                        data-text-close="{{ __('translations.hideAnswer') }}"
                    >{{ __('translations.answer') }}</button>
                </li>
            @endforeach
        </ul>
    @endif
</div>
