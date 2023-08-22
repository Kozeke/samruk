@extends('avl.default')

@section('main')
    <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Настройка районов - просмотр
          <div class="card-actions">
            <a href="{{ route('admin.settings.configurations.areas.index') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          </div>
      </div>
      <div class="card-body">

          <div class="form-group">
            {{ Form::label(null, 'Alias - имя поддомена') }}
            {{ Form::text(null, $area->alias, ['class' => 'form-control bg-light']) }}
          </div>

          <ul class="nav nav-tabs" role="tablist">
              @foreach($langs as $lang)
                <li class="nav-item">
                  <a class="nav-link @if($lang->key == "ru") active show @endif" href="#{{ $lang->key }}" data-toggle="tab"> {{ $lang->name }} </a>
                </li>
              @endforeach
          </ul>
          <div class="tab-content">
            @foreach ($langs as $lang)
              <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="{{$lang->key}}" role="tabpanel">
                {{ Form::text(null, $area->{'title_' . $lang->key} ?? null, ['class' => 'form-control bg-light', 'placeholder' => $lang->name]) }}
              </div>
            @endforeach
          </div>

      </div>
    </div>
@endsection
