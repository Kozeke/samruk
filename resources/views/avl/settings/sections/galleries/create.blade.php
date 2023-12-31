@extends('avl.default')

@section('js')
  <script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>

  <script src="/avl/js/modules/settings/news/edit.js" charset="utf-8"></script>
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>

  <script src="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.js" charset="utf-8"></script>
@endsection

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection

@section('main')
  <div class="card">
    <div class="card-header">
        <i class="fa fa-align-justify"></i> Добавление альбома
        <div class="card-actions">
          <a href="{{ route('admin.settings.sections.gallery.index', ['id' => $section->id]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          <button type="submit" form="submit" name="button" value="add" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить и добавить новую"><i class="fa fa-plus"></i></button>
          <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить и выйти"><i class="fa fa-floppy-o"></i></button>
          <button type="submit" form="submit" name="button" value="edit" class="btn btn-warning pl-3 pr-3" style="width: 70px;" title="Сохранить и изменить"><i class="fa fa-floppy-o"></i></button>
        </div>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.settings.sections.gallery.store', ['id' => $section->id]) }}" method="post" id="submit">
        {!! csrf_field(); !!}

        <div class="row">
          <div class="col-12 col-sm-4">
            <div class="form-group">
              {{ Form::label(null, 'Дата публикации') }}
              {{ Form::text('gallery_published_at', date('Y-m-d'), ['class' => 'form-control', 'id' => 'datepicker']) }}
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="form-group">
              {{ Form::label(null, 'Время публикации') }}
              {{ Form::text('gallery_published_time', date('H:i'), ['class' => 'form-control timepicker']) }}
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="form-group">
              {{ Form::label(null, 'HTML класс') }}
              {{ Form::text('gallery_class', null, ['class' => 'form-control']) }}
            </div>
          </div>
        </div>

        <ul class="nav nav-tabs" role="tablist">
            @foreach($langs as $lang)
              <li class="nav-item">
                <a class="nav-link @if($lang->key == 'ru') active show @endif" href="#title_{{ $lang->key }}" data-toggle="tab">
                  {{ $lang->name }}
                </a>
              </li>
            @endforeach
        </ul>
        <div class="tab-content">
          @foreach ($langs as $lang)
            <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="title_{{$lang->key}}" role="tabpanel">
              <div class="row">
                <div class="col-12 col-sm-2 col-md-2 col-lg-1">
                  <div class="form-group">
                    <label>Вкл / Выкл</label><br/>
                    <label class="switch switch-3d switch-primary mt-1 mb-1">
                      <input name='gallery_good_{{$lang->key}}' type='hidden' value='0'>
                      <input type="checkbox" class="switch-input" name="gallery_good_{{$lang->key}}" value="1" @if (old('gallery_good_{{$lang->key}}') == 1) checked @endif>
                      <span class="switch-label"></span>
                      <span class="switch-handle"></span>
                    </label>
                  </div>
                </div>
                <div class="col-12 col-sm-10 col-md-10 col-lg-11">
                  <div class="form-group">
                    {{ Form::label(null, 'Название') }}
                    {{ Form::text('gallery_title_' . $lang->key, null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-12">
                  {{ Form::textarea('gallery_description_' . $lang->key, null, ['class' => 'tinymce']) }}
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </form>
    </div>
    <div class="card-footer position-relative">
        <i class="fa fa-align-justify"></i> Добавление новости
        <div class="card-actions">
          <a href="{{ route('admin.settings.sections.gallery.index', ['id' => $section->id]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          <button type="submit" form="submit" name="button" value="add" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить и добавить новую"><i class="fa fa-plus"></i></button>
          <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить и выйти"><i class="fa fa-floppy-o"></i></button>
          <button type="submit" form="submit" name="button" value="edit" class="btn btn-warning pl-3 pr-3" style="width: 70px;" title="Сохранить и изменить"><i class="fa fa-floppy-o"></i></button>
        </div>
    </div>
  </div>
@endsection
