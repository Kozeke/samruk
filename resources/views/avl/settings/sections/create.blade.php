@extends('avl.default')

@section('main')
    <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Структура - создание раздела
          <div class="card-actions">
            <a href="{{ url('/admin/settings/sections') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            <button type="submit" form="submit" name="button" value="add" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить и добавить"><i class="fa fa-plus"></i></button>
            <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
          </div>
      </div>
      <div class="card-body">
        <form action="{{ url('/admin/settings/sections') }}" method="post" id="submit">
          {!! csrf_field(); !!}
          <ul class="nav nav-tabs" role="tablist">
              @foreach($langs as $lang)
                <li class="nav-item">
                  <a class="nav-link @if($lang->key == "ru") active show @endif" href="#{{ $lang->key }}" data-toggle="tab"> {{ $lang->name }} </a>
                </li>
              @endforeach
          </ul>
          <div class="tab-content">
            @foreach ($langs as $lang)
              @php $name = 'name_' . $lang->key; @endphp
              <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="{{$lang->key}}" role="tabpanel">
                <input type="text" class="form-control translite--name-{{ $lang->key }}" name="section_name_{{$lang->key}}">
              </div>
            @endforeach
          </div>
          <br>

          <div class="form-group">
              <label for="section_type">ТИП</label>
              <select name="section_type" class="form-control section_type">
                @foreach (config('avl.sections') as $key => $value)
                  <option value="{{$key}}">{{$value}}</option>
                @endforeach
              </select>
          </div>
          <div class="form-group">
              <label for="section_template">Шаблон</label>
              <select name="section_template" class="form-control section_template">
                <option value="0">Выберите шаблон</option>
                @if ($templates)
                  @foreach($templates as $template)
                    <option value="{{ $template->id }}" @if(old('section_template') == $template->id){{ 'selected' }}@else @if($template->ban == 1){{ 'selected' }}@endif @endif>{{ $template->title }}</option>
                  @endforeach
                @endif
              </select>
          </div>

          <ul class="list-group mb-2">
            <li class="list-group-item">
              <label class="mb-0">Вкл</label>
              <label class="switch switch-3d switch-primary pull-right mb-0">
                <input name='section_good' type='hidden' value='0'>
                <input type="checkbox" class="switch-input" name="section_good" value="1" @if (old('section_good') == 1) checked @endif>
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </li>

            <li class="list-group-item">
              <label class="mb-0">Меню</label>
              <label class="switch switch-3d switch-primary pull-right mb-0">
                <input name='section_menu' type='hidden' value='0'>
                <input type="checkbox" class="switch-input" name="section_menu" value="1" @if (old('section_menu') == 1) checked @endif>
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </li>

            <li class="list-group-item">
              <label class="mb-0">Рубрики</label>
              <label class="switch switch-3d switch-primary pull-right mb-0">
                <input name='section_rubric' type='hidden' value='0'>
                <input type="checkbox" class="switch-input" name="section_rubric" value="1" @if (old('section_rubric') == 1) checked @endif>
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </li>
          </ul>

          <div class="form-group">
              <label for="section_parent">Добавить в</label>
              <select name="section_parent" class="form-control">
                <option selected value="0">------</option>
                @include('avl.settings.sections.blocks.parent', ['sections' => $sections, 'parent' => 0, 'current' => 0, 'pre' => '' ,'level' => 0])
              </select>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="section_alias">АЛИАС</label>
                <input type="text" id="section_alias" name="section_alias" class="form-control" value="{{ old('section_alias') }}">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="section_alias">CSS class</label>
                <input type="text" name="section_classes" class="form-control" value="{{ old('section_classes') }}">
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/modules/settings/sections/section.js" charset="utf-8"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('body').on('change', '.translite--name-ru', function() {
        $("#section_alias").val(translite($(this).val()));
      });
    });

    function translite(text) {
      return text.replace(/([а-яё])|([\s_-])|([^a-z\d])/gi,
      function (all, ch, space, words, i) {
          if (space || words) {
              return space ? '-' : '';
          }
          var code = ch.charCodeAt(0),
              index = code == 1025 || code == 1105 ? 0 :
                  code > 1071 ? code - 1071 : code - 1039,
              t = ['yo', 'a', 'b', 'v', 'g', 'd', 'e', 'zh',
                  'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
                  'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh',
                  'shch', '', 'y', '', 'e', 'yu', 'ya'
              ];
          return t[index];
      });
    };
  </script>
@endsection
