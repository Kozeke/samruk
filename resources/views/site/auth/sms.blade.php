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

    <form class="form-auth form-panel" action="{{ route('sms.generate') }}" method="post">
        {!! csrf_field() !!}

        <div class="col-12 col-xl-6">
            <div class="form-group">
                <label class="form-group__label">Ваш телефон</label>

                <div class="form-group__input">
                    <input class="input" type="text" name="mobile" value="{{ old('mobile') }}" data-input-phone>
                </div>
            </div>
        </div>

        <div class="form-auth__actions">
            <button class="btn btn--secondary" type="submit">Получить СМС</button>
        </div>
    </form>

    <div class="formatted">
        <ul>
            <li>Для арендаторов действующих договоров</li>

            @include('site.cabinet.snippets.questionnaire')
        </ul>
    </div>

@endsection
