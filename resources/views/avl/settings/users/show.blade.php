@extends('avl.default')

@section('main')
  <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> {{ $user->profile->fio }}
          <div class="card-actions">
            <a href="{{ url('/admin/settings/users') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <div class="panel-body text-center">
                <img src="@if (!$user->profile->photo == ''){{ $user->profile->photo }} @else /data/profile/no-profile-photo.jpg @endif" width="100%" id="user-photo">
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="form-group">
              <label for="profile_fio">ФИО</label>
              <span class="form-control">{{ $user->profile->surname }} {{ $user->profile->name }} {{ $user->profile->patronymic }}</span>
            </div>
            <div class="form-group">
              <label for="profile_fio">E-mail</label>
              <span class="form-control">{{ $user->email }}</span>
            </div>
            <div class="form-group">
              <label for="profile_fio">ИИН</label>
              <span class="form-control">{{ $user->profile->iin }}</span>
            </div>
            <div class="form-group">
              <label for="profile_fio">Дата рождения</label>
              <span class="form-control">{{ $user->profile->dob }}</span>
            </div>
            <div class="form-group">
              <label for="profile_fio">Роль пользователя</label>
              <span class="form-control">@if($user->role){{ $user->role->display_name }}@else <i style="color:red;">Роль не назначена</i> @endif</span>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection
