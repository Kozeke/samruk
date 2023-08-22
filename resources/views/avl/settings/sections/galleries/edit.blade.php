@extends('avl.default')

@section('js')
  <script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
  <script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

  <script src="/avl/js/modules/settings/gallery/gallery.js" charset="utf-8"></script>
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>

  <script src="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.js" charset="utf-8"></script>
@endsection

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
  <link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Редактирование : {{ str_limit($gallery->title_ru, 100) }}
          <div class="card-actions">
            <a href="{{ route('admin.settings.sections.gallery.index', ['id' => $section->id]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить изменения"><i class="fa fa-floppy-o"></i></button>
          </div>
      </div>

      <div class="card-body">
        <form action="{{ route('admin.settings.sections.gallery.update', ['id' => $section->id, 'gallery' => $gallery->id]) }}" method="post" id="submit">
          {!! csrf_field(); !!}
          {{ method_field('PUT') }}

          <input type="hidden" id="gallery_id" value="{{ $gallery->id }}">

          <div class="row">
            <div class="col-12 col-sm-4">
              <div class="form-group">
                {{ Form::label(null, 'Дата публикации') }}
                {{ Form::text('gallery_published_at', date('Y-m-d', strtotime($gallery->published_at)), ['class' => 'form-control', 'id' => 'datepicker']) }}
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="form-group">
                {{ Form::label(null, 'Время публикации') }}
                {{ Form::text('gallery_published_time', date('H:i', strtotime($gallery->published_at)), ['class' => 'form-control timepicker']) }}
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="form-group">
                {{ Form::label(null, 'HTML класс') }}
                {{ Form::text('gallery_class', $gallery->class, ['class' => 'form-control']) }}
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
            <li class="nav-item"><a class="nav-link" href="#image" data-toggle="tab">Изображения</a></li>
            <li class="nav-item"><a class="nav-link" href="#video" data-toggle="tab">Видео</a></li>
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
                        <input type="checkbox" class="switch-input" name="gallery_good_{{$lang->key}}" value="1" @if ($gallery->{'good_' . $lang->key} == 1) checked @endif>
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>
                  <div class="col-12 col-sm-10 col-md-10 col-lg-11">
                    <div class="form-group">
                      {{ Form::label(null, 'Название') }}
                      {{ Form::text('gallery_title_' . $lang->key, $gallery->{'title_' . $lang->key}, ['class' => 'form-control']) }}
                    </div>
                  </div>
                  <div class="col-12">
                    {{ Form::textarea('gallery_description_' . $lang->key, $gallery->{'description_' . $lang->key}, ['class' => 'tinymce']) }}
                  </div>
                </div>
              </div>
            @endforeach

            <div class="tab-pane" id="image" role="tabpanel">
              <div class="block--file-upload">
                <input id="upload--photos" name="upload" type="file" />
              </div>
              <div class="row">
                <div class="photo--news col-lg-12">
                  <div class="row">
                    <ul id="sortable" class="list-unstyled sortable--gallery">
                      @foreach ($images as $image)
                        <li class="col-md-6 mb-3 float-left" id="gallerySortable_{{ $image['id'] }}">
                          <div class="col-12">
                            <div class="row border p-2">
                              <div class="col-12 col-md-12 col-lg-4 p-0">
                                <div class="card mb-0">
                                  <div class="card-header p-2">
                                    <div class="row mt-1">
                                      @php $classImage = ($image['good'] == 0) ? '-slash' : '' ; @endphp
                                      @php $mainImage  = ($image['main'] == 1) ? 'fa-check-circle-o' : 'fa-circle-o' ; @endphp
                                      <div class="col-4 col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="change--status" data-model="Media" data-id="{{ $image['id'] }}"><i class="fa fa-eye<?=$classImage?>"></i></a></div>
                                      <div class="col-4 col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="toMainPhoto" data-id="{{ $image['id'] }}"><i class="fa <?=$mainImage?>"></i></a></div>
                                      <div class="col-4 col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="deleteMediaGallery" data-model="Media" data-id="{{ $image['id'] }}"><i class="fa fa-trash-o"></i></a> </div>
                                    </div>
                                  </div>
                                  <div class="card-body p-0">
                                    <img src="/image/resize/260/300/{{ $image['link'] }}">
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-md-12 col-lg-8 p-0">
                                <div class="card mb-0">
                                  <div class="card-footer p-0 bg-white">
                                    <ul class="nav nav-tabs">
                                      @foreach($langs as $lang)
                                        <li class="nav-item p-0">
                                          <a class="nav-link @if($lang->key == 'ru') active show @endif" href="#tab--title-item-{{ $image['id'] }}-{{ $lang->key }}" data-toggle="tab" aria-expanded="false">
                                            {{ $lang->key }}
                                          </a>
                                        </li>
                                      @endforeach
                                    </ul>
                                    <div class="tab-content">
                                      @foreach($langs as $lang)
                                        <div class="p-0 tab-pane @if($lang->key == 'ru') active show @endif" id="tab--title-item-{{ $image['id'] }}-{{ $lang->key }}">
                                          <textarea class="form-control tinymce-mini border-0 media--{{ $image['id'] }}" data-lang="{{ $lang->key }}" placeholder="{{ $lang->key }}">{{ $image['title_' . $lang->key] }}</textarea>
                                        </div>
                                      @endforeach
                                      <button type="button" class="btn btn-primary btn-sm btn-block save--media-content" data-id="{{ $image['id'] }}">Save</button>
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                    <script type="text/javascript">
                      $(document).ready(function() {
                        tinymce_mini('tinymce-mini');
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane" id="video" role="tabpanel">

              <div class="form-group col-12 save--link--video p-0">
                <div class="img-thumbnail">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <select class="form-control" id="select--language-video">
                        @foreach($langs as $lang)
                          <option value="{{ $lang->key }}">{{ $lang->key }}</option>
                        @endforeach
                      </select>
                    </div>
                    <input id="title_video" placeholder="Название" type="text" class="form-control">
                    <input id="link_video" placeholder="Ссылка" type="text" class="form-control">
                    <div class="input-group-append">
                      <a href="#" class="save--video_link"><span class="btn btn-success pl-3 pr-3"><i class="fa fa-floppy-o"></i></span></a>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row video--news">
                <div class="col-md-12">

                  <ul id="sortable-video" class="list-group">
                      @foreach ($videos as $video)
                          @php $classFile = ($video['good'] == 0) ? '-slash' : '' @endphp
                          <li class="col-md-12 list-group-item files--item" id="videoSortable_{{ $video['id'] }}">
                            <div class="img-thumbnail">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><img src="/avl/img/icons/flags/{{ $video['lang'] }}--16.png" alt=""></a></span>
                                  <span class="input-group-text"><a href="#" class="change--status" data-model="Media" data-id="{{ $video['id'] }}"><i class="fa @if($video['good'] == 1){{ 'fa-eye' }}@else{{ 'fa-eye-slash' }}@endif"></i></a></span>
                                  <span class="input-group-text"><a href="#" class="deleteVideo" data-model="Media" data-id="{{ $video['id'] }}"><i class="fa fa-trash-o"></i></a></span>
                                </div>
                                <input type="text" id="title--{{ $video['id'] }}" class="form-control" value="{{ $video['title_' . $video['lang'] ] }}">
                                <input type="text" id="link--{{ $video['id'] }}" class="form-control" value="{{ $video['link'] }}">
                                <div class="input-group-append">
                                  <span class="input-group-text"><a href="#" class="update--video" data-id="{{ $video['id'] }}"><i class="fa fa-floppy-o"></i></a></span>
                                </div>
                              </div>
                            </div>
                          </li>
                      @endforeach
                  </ul>
                </div>
              </div>

            </div>
          </div></br>
        </form>
      </div>

      <div class="card-footer position-relative">
          <i class="fa fa-align-justify"></i> Редактирование : {{ $gallery->title_ru }}
          <div class="card-actions">
            <a href="{{ route('admin.settings.sections.gallery.index', ['id' => $section->id]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить изменения"><i class="fa fa-floppy-o"></i></button>
          </div>
      </div>
    </div>
@endsection
