@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Создание пользователя
            <div class="card-actions">
              <a href="{{ url('/admin/settings/users') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
              <button type="submit" form="submit" name="button" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/settings/users') }}" method="post" id="submit">
              {!! csrf_field(); !!}

              <div class="row">
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Фамилия') }}
                    {{ Form::text('surname', null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Имя') }}
                    {{ Form::text('name', null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Отчество') }}
                    {{ Form::text('patronymic', null, ['class' => 'form-control']) }}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'ИИН') }}
                    {{ Form::text('iin', null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Адрес') }}
                    {{ Form::text('address', null, ['class' => 'form-control']) }}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Мобильный телефон') }}
                    {{ Form::text('mobile', null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Домашний телефон') }}
                    {{ Form::text('homephone', null, ['class' => 'form-control']) }}
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
                    {{ Form::text('email', null, ['class' => 'form-control']) }}
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
                        {{ Form::checkbox('good', 1, null, ['class' => 'switch-input']) }}
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <label for="admin">Разрешить вход в админ-панель</label><br/>
                      <label class="switch switch-3d switch-primary">
                        {{ Form::checkbox('admin', 1, null, ['class' => 'switch-input']) }}
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Роль пользователя') }}
                    {{ Form::select('role_id', $roles, null, ['class' => 'form-control', 'placeholder' => 'Выберите роль пользователя']) }}
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label(null, 'Район') }}
                    {{ Form::select('area_id', $areas, null, ['class' => 'form-control', 'placeholder' => 'Выберите район пользователя']) }}
                  </div>
                </div>
              </div>
          </form>
        </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: "1960:",
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
      });
    });
  </script>
@endsection
