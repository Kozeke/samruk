@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Редактирование пользователя [{{ $user->profile->fio }}]
            <div class="card-actions">
                <a href="{{ url('/admin/settings/users') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
                <button type="submit" form="update" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
            </div>
        </div>
      <div class="card-body" data-id="{{ $user->profile->id }}" id="user_edit">
        <form action="{{ url('/admin/settings/profile/'.$user->id) }}" method="post" id="update">
          {!! csrf_field(); !!}
          {{ method_field('PUT') }}
          <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <input id="profile--photo" type="file" name="">
              <div class="panel-body text-center">
                <img src="@if (!$user->photo == ''){{ $user->photo }} @else{{ '/data/profile/no-profile-photo.jpg' }}@endif" width="100%" id="user-photo">
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="form-group">
              <label>Имя</label>
              <input type="text" name="profile_name" class="form-control" value="@if(old('profile_name')){{ old('profile_name') }}@else{{ $user->profile->name }}@endif">
            </div>
            <div class="form-group">
              <label>Фамилия</label>
              <input type="text" name="profile_surname" class="form-control" value="@if(old('profile_surname')){{ old('profile_surname') }}@else{{ $user->profile->surname }}@endif">
            </div>
            <div class="form-group">
              <label>Отчество</label>
              <input type="text" name="profile_patronymic" class="form-control" value="@if(old('profile_patronymic')){{ old('profile_patronymic') }}@else{{ $user->profile->patronymic }}@endif">
            </div>
            <div class="form-group">
              <label>Дата рождения</label>
              <input type="text" name="profile_dob" class="form-control" value="{{ $user->profile->dob }}" id="datepicker">
            </div>
            <div class="form-group">
                <label>ИИН</label>
                <input type="text" name="profile_iin" class="form-control" value="@if(old('profile_iin')){{ old('profile_iin') }}@else{{ $user->profile->iin }}@endif">
            </div>
            <div class="form-group">
                <label>E-Mail</label>
                <input type="text" name="profile_email" class="form-control" value="@if(old('profile_email')){{ old('profile_email') }}@else{{ $user->email }}@endif">
            </div>
            <div class="form-group">
                <label>Адрес</label>
                <input type="text" name="profile_adds" class="form-control" value="@if(old('profile_adds')){{ old('profile_adds') }}@else{{ $user->profile->adds }}@endif">
            </div>
            <div class="form-group">
                <label>Домашний телефон</label>
                <input type="text" name="profile_phone" class="form-control" value="@if(old('profile_phone')){{ old('profile_phone') }}@else{{ $user->profile->phone }}@endif">
            </div>
            <div class="form-group">
                <label>Мобильный телефон</label>
                <input type="text" name="profile_mobile" class="form-control" value="@if(old('profile_mobile')){{ old('profile_mobile') }}@else{{ $user->profile->mobile }}@endif">
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="text" name="profile_password" class="form-control" value="">
            </div>
            <div class="form-group">
                <label>Пол</label>
                <select name="profile_sex" class="form-control">
                  <option value="1" @if ($user->profile->sex == 1){{ 'selected' }}@endif>Мужской</option>
                  <option value="2" @if (old('profile_sex') == 2){{ 'selected' }}@elseif ($user->profile->sex == 2){{ 'selected' }}@else{{ '' }}@endif>Женский</option>
                </select>
            </div>
          </div>
          </div>
          </form>
        </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
  <script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

  <script src="/avl/js/modules/settings/users/edit.js" charset="utf-8"></script>
@endsection
