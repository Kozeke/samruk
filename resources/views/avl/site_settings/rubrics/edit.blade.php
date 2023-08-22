@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
  <link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> <b>{{ $section['name_ru'] }}</b> - редактирование рубрик
        <div class="card-actions">
          <a href="{{ route('admin.site.settings.rubrics.index', ['id' => $id]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.site.settings.rubrics.update', ['id' => $section['id'], 'rubric' => $rubric->id]) }}" method="post" id="submit">
          {!! csrf_field(); !!}
          {{ method_field('PUT') }}
          <input type="hidden" id="rubric_id" value="{{ $rubric->id }}">
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label>Дата публикации</label>
                <input type="text" name="rubric_published_at" class="form-control" value="@if(old('rubric_published_at')){{ old('rubric_published_at') }}@else{{ date('Y-m-d', strtotime($rubric->published_at)) }}@endif" id="datepicker">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label>Время публикации</label>
                <input type="text" name="rubric_published_time" class="form-control timepicker" value="@if(old('rubric_published_time')){{ old('rubric_published_time') }}@else{{ date('H:i', strtotime($rubric->published_at)) }}@endif">
              </div>
            </div>
          </div>

          <ul class="nav nav-tabs" role="tablist">
            @foreach($langs as $lang)
              <li class="nav-item">
                <a id="tabClick" class="nav-link @if($lang->key == 'ru') active show @endif" href="#rubric-tab_{{ $lang->key }}" data-lang="{{$lang->key}}" data-toggle="tab">
                  {{ $lang->name }}
                </a>
              </li>
            @endforeach
            <li class="nav-item"><a class="nav-link" href="#files" data-toggle="tab">Файлы</a></li>
            <li class="nav-item"><a class="nav-link" href="#images" data-toggle="tab">Изображения</a></li>
          </ul>
          <div class="tab-content">
            @foreach ($langs as $lang)
              <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="rubric-tab_{{ $lang->key }}" role="tabpanel">
                @php $good = 'good_' . $lang->key; @endphp
                @php $title = 'title_' . $lang->key; @endphp
                @php $description = 'description_' . $lang->key; @endphp
                @php $image = 'image_' . $lang->key; @endphp

                <div class="row">
                  <div class="col-1">
                    <div class="form-group">
                      <label>Вкл</label><br/>
                      <label class="switch switch-3d switch-primary">
                        <input name='rubric_good_{{ $lang->key }}' type='hidden' value='0'>
                        <input type="checkbox" class="switch-input" name="rubric_good_{{ $lang->key }}" value="1" @if ($rubric->$good == 1) checked @endif>
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="col-11">
                    <div class="form-group">
                      <label>Наименование</label>
                      <input type="text" class="form-control" name="rubric_title_{{ $lang->key }}" value="@if(old('rubric_title_' . $lang->key )){{ old('rubric_title_' . $lang->key ) }}@else{{ $rubric->$title }}@endif">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <textarea class="form-control tinymce" name="rubric_description_{{$lang->key}}" rows="15">@if(old('rubric_description_' . $lang->key )){{ old('rubric_description_' . $lang->key ) }}@else{{ $rubric->$description }}@endif</textarea>
                  </div>
                </div>

              </div>
            @endforeach
            <div class="tab-pane"  id="files" role="tabpanel">
              <div class="block--file-upload">
                <div class="form-group">
                    <select class="form-control" id="select--language-file">
                        @foreach($langs as $lang)
                          <option value="{{ $lang->key }}">{{ $lang->key }}</option>
                        @endforeach
                    </select>
                </div>
                <input id="upload--files" name="upload" type="file" />
              </div>
              <div class="row files--news">
                <div class="col-md-12">
                  <ul id="sortable-files" class="list-group">
                    @if($rubric->files())
                      @foreach ($rubric->files()->orderBy('sind', 'desc')->get() as $file)
                        @php $classFile = ($file['good'] == 0) ? '-slash' : '' @endphp
                        <li class="col-md-12 list-group-item files--item" id="mediaSortable_{{ $file['id'] }}">
                          <div class="img-thumbnail">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text" style="cursor: move;"><img src="/avl/img/icons/flags/{{ $file['lang'] }}--16.png" alt=""></a></span>
                                <span class="input-group-text"><a href="#" class="change--status" data-model="Media" data-id="{{ $file['id'] }}"><i class="fa @if($file['good'] == 1){{ 'fa-eye' }}@else{{ 'fa-eye-slash' }}@endif"></i></a></span>
                                  <span class="input-group-text"><a href="/file/save/{{ $file['id'] }}" target="_blank"><i class="fa fa-download"></i></a></span>
                                  <span class="input-group-text"><a href="#" class="deleteMedia" data-model="Media" data-id="{{ $file['id'] }}"><i class="fa fa-trash-o"></i></a></span>
                                </div>
                                <input type="text" id="title--{{ $file['id'] }}" class="form-control" value="{{ $file['title_' . $file['lang'] ] }}">
                                <div class="input-group-append">
                                  <span class="input-group-text"><a href="#" class="save--file-name" data-id="{{ $file['id'] }}"><i class="fa fa-floppy-o"></i></a></span>
                                </div>
                              </div>
                            </div>
                          </li>
                        @endforeach
                    @endif
                  </ul>
                </div>
              </div>
            </div>

            <div class="tab-pane" id="images" role="tabpanel">
              <div class="block--file-upload">
                <input id="upload--photos" name="upload" type="file" />
              </div>
              <div class="row">
                <div class="photo--news col-lg-12">
                  <div class="row">
                    <ul id="sortable" class="list-unstyled">
                      @if($rubric->images())
                        @foreach ($rubric->images()->orderBy('sind', 'desc')->get() as $image)
                          <li class="col-md-2 float-left" id="mediaSortable_{{ $image['id'] }}">
                            <div class="card">
                              <div class="card-header">
                                <div class="row">
                                  @php $classImage = ($image['good'] == 0) ? '-slash' : '' ; @endphp
                                  @php $mainImage  = ($image['main'] == 1) ? 'fa-check-circle-o' : 'fa-circle-o' ; @endphp
                                  <div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="change--status" data-model="Media" data-id="{{ $image['id'] }}"><i class="fa fa-eye<?=$classImage?>"></i></a></div>
                                  <div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="toMainPhoto" data-model="Media" data-id="{{ $image['id'] }}"><i class="fa <?=$mainImage?>"></i></a></div>
                                  <div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="deleteMedia" data-model="Media" data-id="{{ $image['id'] }}"><i class="fa fa-trash-o"></i></a> </div>
                                </div>
                              </div>
                              <div class="card-body p-0">
                                <img src="/image/resize/260/230/{{ $image['link'] }}">
                              </div>
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
                                      <textarea class="form-control border-0 media--{{ $image['id'] }}" data-lang="{{ $lang->key }}" placeholder="{{ $lang->key }}">{{ $image['title_' . $lang->key] }}</textarea>
                                      <button type="button" class="btn btn-primary btn-sm btn-block save--media-content" data-id="{{ $image['id'] }}">Save</button>
                                    </div>
                                  @endforeach
                                </div>
                              </div>
                            </div>
                          </li>
                        @endforeach
                      @endif
                    </ul>
                  </div>
                </div>
              </div>
            </div>

          </div></br>
        </form>
      </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
  <script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

  <script src="/avl/js/modules/site-settings/rubrics.js" charset="utf-8"></script>
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>

  <script src="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.js" charset="utf-8"></script>
@endsection
