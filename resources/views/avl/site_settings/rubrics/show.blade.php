@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> Просмотр : {{$link->title_ru}}
        <div class="card-actions">
          <a href="{{ url('/admin/settings/sections/'.$id.'/links') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ url('/admin/settings/sections/'.$id.'/links/'.$section->id) }}" method="post" id="submit">
          {!! csrf_field(); !!}
          {{ method_field('PUT') }}
          <div class="form-group">
            <label for="links_published_at">Дата публикации</label>
            <span name="links_published_at" class="form-control">{{ date('Y-m-d', strtotime($link->published_at)) }}</span>
          </div>
          <div class="form-group">
            <label>Класс</label>
            <span class="form-control" name="links_class">@if ($link->class == "")Нет класса@else{{ $link->class }}@endif</span>
          </div>
          <ul class="nav nav-tabs" role="tablist">
            @foreach($langs as $lang)
            <li class="nav-item">
              <a class="nav-link @if($lang->key == 'ru') active show @endif" href="#title_{{ $lang->key }}" data-lang="{{$lang->key}}" data-toggle="tab">
                {{ $lang->name }}
              </a>
            </li>
            @endforeach
          </ul>
          <div class="tab-content">
            @foreach ($langs as $lang)
              <div class="tab-pane @if($lang->key == "ru") active show @endif" id="title_{{$lang->key}}" role="tabpanel">
                @php $title = 'title_' . $lang->key; @endphp
                @php $good = 'good_' . $lang->key; @endphp
                @php $description = 'description_' . $lang->key; @endphp
                @php $link_lang = 'link_' . $lang->key; @endphp
                @php $photo = 'photo_' . $lang->key; @endphp
                <div class="form-group">
                  <label>Наименование</label>
                  <span class="form-control" name="links_title_{{$lang->key}}">@if ($link->$title == "")Нет наименования на этом языке@else{{ $link->$title }}@endif</span>
                </div>
                <div class="form-group">
                  <label>Ссылка</label>
                  <span class="form-control" name="links_link_{{$lang->key}}">@if ($link->$link_lang == "")Нет ссылки на этом языке@else{{ $link->$link_lang }}@endif</span>
                </div>
                <div class="form-group">
                  <label>Описание</label>
                  <span class="form-control" name="links_description_{{$lang->key}}" rows="15">@if ($link->$description == "")Нет описания на этом языке@else{{ $link->$description }}@endif</span>
                </div>
                <div class="form-group">
                <div class="row">
                  <div class="photo--links col-lg-12">
                    <div class="row">
                      <ul id="sortable" class="col-md-12 list-unstyled">
                        <li class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 float-left" id="link_photo-{{$lang->key}}">
                          @if (!$link->$photo == '')
                          <div class="card card-hover">
                            <div class="card-body p-0">
                              <div class="card-header card-header-top">
                              </div>
                              <div class="card-pic" style="background-image: url('/image/resize/260/230/{{$link->$photo}}');"></div>
                              <div class="card-header card-header-bottom"></div>
                            </div>
                            <div class="card-footer p-0 bg-white">
                              <ul class="nav nav-tabs">
                                @foreach($langs as $lang)
                                <li class="nav-item p-0">
                                  <a class="nav-link @if($lang->key == 'ru') active show @endif" href="#tab--title-item-{{ $lang->key }}" data-toggle="tab" aria-expanded="false">
                                    <i class="icon--language icon--language-{{$lang->key}}"></i>
                                  </a>
                                </li>
                                @endforeach
                              </ul>
                              <div class="tab-content">
                                @foreach($langs as $lang)
                                <div class="p-0 tab-pane @if($lang->key == 'ru') active show @endif" id="tab--title-item-{{ $lang->key }}">
                                  <textarea class="form-control border-0 media-" data-lang="{{ $lang->key }}" placeholder="{{ $lang->key }}"></textarea>
                                  <button type="button" class="btn btn-primary btn-sm btn-block save--media-content" data-id="">Save</button>
                                </div>
                                @endforeach
                              </div>
                            </div>
                          </div>
                          @else
                          @endif
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
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
@endsection
