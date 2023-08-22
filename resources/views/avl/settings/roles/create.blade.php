@extends('avl.default')

@section('main')
  <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Создание роли
          <div class="card-actions">
            <a href="{{ url('/admin/settings/roles') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
          </div>
      </div>
      <div class="card-body">
          <form action="{{ url('/admin/settings/roles') }}" method="post" id="submit">
              {!! csrf_field(); !!}
              <div class="form-group">
                  <label for="avl-name">Имя</label>
                  <input type="text" id="avl-name" name="role_name" class="form-control" value="{{ old('role_name') }}">
              </div>
              <div class="form-group">
                  <label for="display_name">Имя для отображения</label>
                  <input type="text" id="display_name" name="role_display_name" class="form-control" value="{{ old('role_display_name') }}">
              </div>
              <p class="text-secondary">
                <small>* После создания роли вы сможете назначить права доступа</small>
              </p>
          </form>
      </div>
  </div>
@endsection
