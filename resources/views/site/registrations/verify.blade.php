@extends('site.registrations.base')

@section('registrations')

    <h2 class="h1 form-title">Подтверждение</h2>

    @if ($success)
        <div class="form-sent">
            <div class="form-sent-pic">
                <img src="/site/img/icons/check.png">
            </div>

            <div class="form-sent-text">
                <p>{{ trans('translations.forms.register.verify.success') }}</p>
                <p><a href="{{ route('auth.index') }}">Войти</a></p>
            </div>
        </div>
    @else
        <div class="form-field-text text-danger">
            <p>Код верификации не найден.</p>
        </div>
    @endif

@endsection
