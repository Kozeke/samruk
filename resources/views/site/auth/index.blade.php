@extends('site.registrations.base')

@push('js')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush

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

    @if (session('error'))
        <div class="alert alert--danger">{{ session('error') }}</div>
    @endif

    @if (session('success'))
        <div class="alert alert--success">{{ session('success') }}</div>
    @endif

    <form class="form-auth form-panel" action="{{ route('auth.login') }}" method="post">
        {!! csrf_field() !!}

        <div class="row row--sm">
            <div class="col-12 col-xl-6">
                <div class="form-group">
                    <label class="form-group__label">Ваш email</label>

                    <div class="form-group__input">
                        <input class="input" type="email" name="email" value="{{ old('email') }}">
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="form-group">
                    <label class="form-group__label">Пароль</label>

                    <div class="form-group__input">
                        <input class="input" type="password" name="password">
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-12">
                <div class="form-auth__recaptcha form-group">
                    <div class="g-recaptcha" data-sitekey="6LdL-uAUAAAAAAeVYU5gh-25XNyhfKTabxxWkglk"></div>
                </div>
            </div>

            <div class="col-12 col-xl-12">
                <div class="form-auth__actions">
                    <a
                        class="btn btn--outline-secondary"
                        href="{{ route('registrations.restore') }}"
                    >Забыли пароль?</a>

                    <button class="btn btn--secondary" type="submit">Войти</button>
                </div>
            </div>
        </div>
    </form>

    <div class="formatted">
        <ul>
            <li>Для арендаторов действующих договоров</li>

            @include('site.cabinet.snippets.questionnaire')

            <li>
                <a href="/instructions/instruction.docx" target="_blank">Инструкция для пользователя</a>
            </li>
        </ul>
    </div>

@endsection
