@extends('avl.default')

@section('main')
    <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Настройка районов - добавление
          <div class="card-actions">
            <a href="{{ route('admin.settings.configurations.areas.index') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            <button type="submit" form="submit" name="button" value="add" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить и добавить"><i class="fa fa-plus"></i></button>
            <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
          </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.settings.configurations.areas.store') }}" method="post" id="submit">
          {!! csrf_field(); !!}

          <div class="form-group">
            {{ Form::label(null, 'Alias - имя поддомена') }}
            {{ Form::text('alias', null, ['class' => 'form-control']) }}
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
                {{ Form::text('title_' . $lang->key, null, ['class' => 'form-control', 'placeholder' => $lang->name]) }}
              </div>
            @endforeach
          </div>
        </form>
      </div>
    </div>
@endsection
