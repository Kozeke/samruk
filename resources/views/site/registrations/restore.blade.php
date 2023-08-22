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

    @if (session()->has('success'))
        <div class="alert alert--success text-center mb-3">
            Инструкции успешно отправлены на e-mail, указанный при регистрации.
        </div>
    @endif

    <form class="form-auth form-panel" action="{{ route('registrations.restore.post') }}" method="post">
        {!! csrf_field(); !!}

        <div class="form-group">
            <label class="form-group__label">Ваш email</label>

            <div class="form-group__input">
                <input class="input input--secondary" type="text" name="email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="form-auth__actions">
            <button class="btn btn--secondary" type="submit">Сбросить пароль</button>
        </div>
    </form>

@endsection
