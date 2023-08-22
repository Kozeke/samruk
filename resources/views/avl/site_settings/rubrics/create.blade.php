@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
  <link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> <b>{{ $section['name_ru'] }}</b> - добавление рубрик
        <div class="card-actions">
          <a href="{{ route('admin.site.settings.rubrics.index', ['id' => $section['id']]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          <button type="submit" form="submit" name="button" value="add" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить и добавить новую"><i class="fa fa-plus"></i></button>
          <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить и перейти к списку"><i class="fa fa-floppy-o"></i></button>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.site.settings.rubrics.store', ['id' => $section['id']]) }}" method="post" id="submit">
          {!! csrf_field(); !!}
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label>Дата публикации</label>
                <input type="text" name="rubric_published_at" class="form-control" value="{{ (old('rubric_published_at')) ? old('rubric_published_at') : date('Y-m-d') }}" id="datepicker">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label>Время публикации</label>
                <input type="text" name="rubric_published_time" class="form-control timepicker" value="{{ (old('rubric_published_time')) ? old('rubric_published_time') : date('H:i') }}">
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
                  <div class="col-1">
                    <div class="form-group">
                      <label>Вкл</label><br/>
                      <label class="switch switch-3d switch-primary">
                        <input name='rubric_good_{{$lang->key}}' type='hidden' value='0'>
                        <input type="checkbox" class="switch-input" name="rubric_good_{{$lang->key}}" value="1">
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>
                  <div class="col-11">
                    <div class="form-group">
                      <label>Название</label>
                      <input type="text" class="form-control" name="rubric_title_{{$lang->key}}" value="">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <textarea class="form-control tinymce" name="rubric_description_{{$lang->key}}" rows="15"></textarea>
                </div>
              </div>
            @endforeach
          </div></br>
        </form>
      </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
  <script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

  <script src="/avl/js/modules/settings/links/edit.js" charset="utf-8"></script>
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>

  <script src="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.js" charset="utf-8"></script>
@endsection
