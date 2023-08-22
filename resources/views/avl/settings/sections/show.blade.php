@extends('avl.default')

@section('main')
    <div class="card">
      @if ($section)
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Структура - раздел: {{$section->name_ru}}
            <div class="card-actions">
              <a href="{{ url('/admin/settings/sections') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="section_name">Наименование</label>
            <span class="form-control">{{ $section->name_ru }}</span>
          </div>
          <div class="form-group">
              <label for="section_type">ТИП</label>
              <span class="form-control">{{ $section->type }}</span>
          </div>
          <div class="form-group">
            <label for="section_template">Шаблон</label>
            <span class="form-control">{{ $section->current_template->title }}</span>
          </div>
          <div class="form-group">
            <label for="section_parent">Добавить в</label>
            <span class="form-control">{{ $section->parent_id }}</span>
          </div>
          <div class="form-group">
            <label for="section_alias">АЛИАС</label>
            <span class="form-control">{{ $section->alias }}</span>
          </div>
        </div>
        @endif
    </div>
@endsection
