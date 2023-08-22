@extends('site.registrations.base')


@section('form')
    @if (session('success'))
        <div class="alert alert--success" role="alert"> {{session('success')}}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert--danger">
            {{ session('error') }}
        </div>
    @endif

    <form class="form-auth form-panel" action="{{ route('auth.login.otp') }}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="user_id" value="{{$user_id}}"/>

        <div class="col-12 col-xl-6">
            <div class="form-group">
                <label class="form-group__label">Одноразовый пароль</label>

                <div class="form-group__input">
                    <input class="input" type="text" name="otp" value="{{ old('otp') }}">
                </div>
            </div>
        </div>

        <div class="form-auth__actions">
            <button class="btn btn--secondary" type="submit">Войти</button>
        </div>
    </form>

    <div class="formatted">
        <ul>
            <li>Для арендаторов действующих договоров</li>

            @include('site.cabinet.snippets.questionnaire')
        </ul>
    </div>

@endsection
