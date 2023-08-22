@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> Редактирование пользователя [ {{ $user->surname . ' ' .$user->name . ' ' . $user->patronymic }} ]
        <div class="card-actions">
          <a href="{{ url('/admin/settings/users') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          <button type="submit" form="update" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
        </div>
      </div>
      <div class="card-body" data-id="{{ $user->id }}" id="user_edit">
        <form action="{{ url('/admin/settings/users/'.$user->id) }}" method="post" id="update">
          {!! csrf_field(); !!}
          {{ method_field('PUT') }}
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <input id="profile--photo" type="file" name="">
                <div class="panel-body text-center">
                  <img src="@if (!$user->photo == ''){{ $user->photo }} @else /data/profile/no-profile-photo.jpg @endif" width="100%" id="user-photo">
                </div>
              </div>
            </div>
            <div class="col-md-9">

              <div class="row">
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Фамилия') }}
                    {{ Form::text('surname', $user->surname ?? null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Имя') }}
                    {{ Form::text('name', $user->name ?? null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Отчество') }}
                    {{ Form::text('patronymic', $user->patronymic ?? null, ['class' => 'form-control']) }}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'ИИН') }}
                    {{ Form::text('iin', $user->iin ?? null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Адрес') }}
                    {{ Form::text('address', $user->address ?? null, ['class' => 'form-control']) }}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Мобильный телефон') }}
                    {{ Form::text('mobile', $user->mobile ?? null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Домашний телефон') }}
                    {{ Form::text('homephone', $user->homephone ?? null, ['class' => 'form-control']) }}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <h5 class="border-top pt-2 pb-2">Данные для авторизации</h5>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'E-Mail') }}
                    {{ Form::text('email', $user->email ?? null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Пароль') }}
                    {{ Form::password('password', ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-12">
                  <span class="border-top d-block">&nbsp;</span>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                      <label for="good">Разрешить авторизацию</label><br/>
                      <label class="switch switch-3d switch-primary">
                        {{ Form::checkbox('good', 1, $user->good, ['class' => 'switch-input']) }}
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <label for="admin">Разрешить вход в админ-панель</label><br/>
                      <label class="switch switch-3d switch-primary">
                        {{ Form::checkbox('admin', 1, $user->admin, ['class' => 'switch-input']) }}
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                </div>
              </div>

              @if($user->role->name != 'admin')
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      {{ Form::label(null, 'Роль пользователя') }}
                      {{ Form::select('role_id', $roles, $user->role_id ?? null, ['class' => 'form-control', 'placeholder' => 'Выберите роль пользователя']) }}
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      {{ Form::label(null, 'Район') }}
                      {{ Form::select('area_id', $areas, $user->area_id ?? null, ['class' => 'form-control', 'placeholder' => 'Выберите район пользователя']) }}
                    </div>
                  </div>
                </div>
              @endif
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
