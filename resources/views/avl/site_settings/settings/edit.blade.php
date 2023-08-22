@extends('avl.default')

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Общие   настройки
            <div class="card-actions">
              <a href="{{ url('/admin') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
              <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
            </div>
        </div>
        <div class="card-body">
          <form action="{{ url('/admin/site-settings/settings/'.$settings->id) }}" method="post" id="submit">
            {!! csrf_field(); !!}
            {{ method_field('PUT') }}
            <ul class="nav nav-tabs" role="tablist">
                @foreach($langs as $lang)
                  <li class="nav-item">
                    <a class="nav-link @if($lang->key == 'ru') active show @endif" href="#{{ $lang->key }}" data-toggle="tab">
                      {{ $lang->name }}
                    </a>
                  </li>
                @endforeach
            </ul>
            <div class="tab-content">
              @foreach ($langs as $lang)
                @php $title = 'title_' . $lang->key; @endphp
                @php $description = 'description_' . $lang->key; @endphp
                @php $keywords = 'keywords_' . $lang->key; @endphp
                <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="{{$lang->key}}" role="tabpanel">
                    <span>Заголовок</span>
                    <input type="text" class="form-control" name="settings_title_{{$lang->key}}" value="{{$settings->$title}}">
                    <span>Описание</span>
                    <textarea class="form-control tinymce" name="settings_description_{{$lang->key}}" rows="15">{{$settings->$description}}</textarea>
                    <span>Ключевые слова</span>
                    <textarea class="form-control tinymce" name="settings_keywords_{{$lang->key}}" rows="15">{{$settings->$keywords}}</textarea>
                </div>
              @endforeach
            </div>
          </form>
        </div>
    </div>
@endsection


@section('js')
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>
@endsection
