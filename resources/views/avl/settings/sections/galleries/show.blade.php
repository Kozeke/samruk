@extends('avl.default')

@section('js')
  <script src="/avl/js/modules/settings/news/edit.js" charset="utf-8"></script>
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>
@endsection

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Раздел: {{ $section->name }}
          <div class="card-actions">
            <a href="{{ route('admin.settings.sections.gallery.index', ['id' => $section->id]) }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          </div>
      </div>
      <div class="card-body">

        <div class="row">
          <div class="col-12 col-sm-4">
            <div class="form-group">
              {{ Form::label(null, 'Дата публикации') }}
              {{ Form::text(null, date('Y-m-d', strtotime($gallery->published_at)), ['class' => 'form-control bg-light']) }}
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="form-group">
              {{ Form::label(null, 'Время публикации') }}
              {{ Form::text(null, date('H:i', strtotime($gallery->published_at)), ['class' => 'form-control bg-light']) }}
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="form-group">
              {{ Form::label(null, 'HTML класс') }}
              {{ Form::text(null, $gallery->class, ['class' => 'form-control bg-light']) }}
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
                      <input type="checkbox" class="switch-input" value="1" @if ($gallery->{'good_' . $lang->key}) == 1) checked @endif>
                      <span class="switch-label"></span>
                      <span class="switch-handle"></span>
                    </label>
                  </div>
                </div>
                <div class="col-12 col-sm-10 col-md-10 col-lg-11">
                  <div class="form-group">
                    {{ Form::label(null, 'Название') }}
                    {{ Form::text('gallery_title_' . $lang->key, $gallery->{'title_' . $lang->key}, ['class' => 'form-control bg-light']) }}
                  </div>
                </div>
                <div class="col-12">
                  {{ Form::textarea('gallery_description_' . $lang->key, $gallery->{'description_' . $lang->key}, ['class' => 'tinymce']) }}
                </div>
              </div>
            </div>
          @endforeach
        </div>

      </div>
    </div>
@endsection
