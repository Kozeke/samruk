@extends('site.registrations.base')

@section('form')

    @if ($success === true)
        <div class="alert alert--success">Пароль успешно сменен</div>
    @endif

    @if ($success === false)
        <div class="alert alert--danger">Произошла ошибка попробуйте еще раз</div>
    @endif

@endsection
