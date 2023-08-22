@extends('avl.default')

@section('main')
  <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Изменить язык
          <div class="card-actions">
            <a href="{{ url('/admin/settings/langs') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
          </div>
      </div>
      <div class="card-body">
          <form action="{{ url('/admin/settings/langs/'. $lang->id) }}" method="post" id="submit">
              {!! csrf_field(); !!}
              {{ method_field('PUT') }}
              <div class="form-group">
                  <label for="langs--select_key">Язык</label>
                  <span class="form-control bg-light">{{ $lang->name }}</span>
              </div>
              <div class="form-group">
                <label for="langs--select_name">Название для отображения</label>
                <input id="langs--select_name" class="form-control" type="text" name="lang_name" value="@if(old('lang_name')){{ old('lang_name') }}@else{{ $lang->name }}@endif">
              </div>
          </form>
      </div>
  </div>
@endsection
