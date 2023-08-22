@extends('site.registrations.base')

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/node-forge@0.7.0/dist/forge.min.js"></script>
    <script src="/site/js/auth_cert/jquery.js"></script>
    <script src="/site/js/auth_cert/jquery.blockUI.js"></script>
    <script src="/site/js/auth_cert/ncalayer.js"></script>
    <script src="/site/js/auth_cert/process-ncalayer-calls.js"></script>

@endpush

@section('form')

    @if (session('error'))
        <div class="alert alert--danger">
            {{ session('error') }}
        </div>
    @endif

    <form class="form-auth form-panel" action="{{ route('auth.login.ecp') }}" method="post">
        {!! csrf_field() !!}

        @include('site.auth.form-signature')

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
