@if (Auth::check())
    <a class="header__login-btn" href="{{ route('cabinet.index') }}" title="Для арендаторов действующих договоров">
        {!! icon('icon--user') !!}
        <span>{{ Auth::user()->name }}</span>
    </a>
@else
    <a class="header__login-btn" href="{{ route('auth.index') }}" title="Для арендаторов действующих договоров">
        {!! icon('icon--user') !!}
        <span>{{ __('translations.personal_cabinet') }}</span>
    </a>
@endif
