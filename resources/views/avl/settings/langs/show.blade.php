@extends('avl.default')

@section('main')
  <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Просмотр языка
          <div class="card-actions">
            <a href="{{ url('/admin/settings/langs') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          </div>
      </div>
      <div class="card-body">
        <div class="form-group">
            <label for="langs--select_key">Показывать на сайте: </label>
            <span class="badge @if ($lang->good)badge-success @else badge-danger @endif p-2">
              {{ config('avl.good.' . $lang->good) }}
            </span>
        </div>
        <div class="form-group">
          <label>Код</label>
          <span class="form-control">{{ $lang->key }}</span>
        </div>
        <div class="form-group">
          <label>Название</label>
          <span class="form-control">{{ $lang->name }}</span>
        </div>
        <div class="form-group">
          <label>Добавлен</label>
          <span class="form-control">{{ $lang->created_at }}</span>
        </div>
      </div>
  </div>
@endsection
