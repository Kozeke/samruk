@extends('site.registrations.base')

@section('form')

    @if ($errors->any())
        <div class="alert alert--danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($success === true)
        <form
            class="form-auth form-panel"
            action="{{ route('registrations.restore.save_pass', ['verify' => $verify]) }}"
            method="post"
        >
            {!! csrf_field() !!}

            <div class="form-group @if ($errors->has('registrations_password')){{ 'has-error' }}@endif">
                <label class="form-group__label">Введите новый пароль</label>

                <div class="form-group__input">
                    <input
                        class="input"
                        type="password"
                        name="password"
                        value="{{ old('registrations_password') }}"
                    >
                </div>
            </div>

            <div class="form-group @if ($errors->has('registrations_confirm')){{ 'has-error' }}@endif">
                <label class="form-group__label">Подтвердите новый пароль</label>

                <div class="form-group__input">
                    <input
                        class="input"
                        type="password"
                        name="confirm"
                        value="{{ old('registrations_confirm') }}"
                    >
                </div>
            </div>

            <div class="form-auth__actions">
                <button class="btn btn--secondary" type="submit">Сохранить</button>
            </div>
        </form>
    @else
        <div class="alert alert--danger">
            <p>Ошибка верификации</p>
        </div>
    @endif

@endsection
