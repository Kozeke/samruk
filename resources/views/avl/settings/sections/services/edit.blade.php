@extends('avl.default')

@section('js')
  <script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
  <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
  <script src="/avl/js/modules/settings/services/services.js" charset="utf-8"></script>
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
        <i class="fa fa-align-justify"></i>  Редактирование: {{ $service->title }}
        <div class="card-actions">
          <a href="{{ url('/admin/settings/sections/'.$section->id.'/services') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить и перейти к списку"><i class="fa fa-floppy-o"></i></button>
        </div>
    </div>

    <div class="card-body">

      {{ Form::open(['route' => ['admin.settings.sections.services.update', $section->id, $service->id], 'method' => 'put', 'id' => 'submit']) }}

        <div class="row">

          <div class="col-12 col-sm-4">
            <div class="form-group">
              {{ Form::label(null, 'Номер') }}
              {{ Form::text('services_number', $service->number, ['class' => 'form-control']) }}
            </div>
          </div>

          <div class="col-12 col-sm-4">
            <div class="form-group">
              {{ Form::label(null, 'Дата публикации') }}
              {{ Form::text('services_published_at', date('Y-m-d', strtotime($service->published_at)), ['class' => 'form-control', 'id' => 'datepicker']) }}
            </div>
          </div>

          <div class="col-12 col-sm-4">
            <div class="form-group">
              {{ Form::label(null, 'Время публикации') }}
              {{ Form::text('services_published_time', date('H:i', strtotime($service->published_at)), ['class' => 'form-control timepicker']) }}
            </div>
          </div>

        </div>

        <ul class="nav nav-tabs" role="tablist">
          @foreach($langs as $lang)
            <li class="nav-item">
              <a class="nav-link @if($lang->key == 'ru') active show @endif" href="#title_{{ $lang->key }}" data-toggle="tab">{{ $lang->name }}</a>
            </li>
          @endforeach
          <li class="nav-item">
            <a class="nav-link" href="#adds" data-toggle="tab">Адрес</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#tab--attributes" data-toggle="tab">Атрибуты</a>
          </li>
        </ul>

        <div class="tab-content">
          @foreach ($langs as $lang)
            @php $good = 'good_' . $lang->key; @endphp
            @php $title = 'title_' . $lang->key; @endphp
            @php $description = 'description_' . $lang->key; @endphp

            <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="title_{{$lang->key}}" role="tabpanel">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active show" href="#sub-tab_{{ $lang->key }}-index" data-toggle="tab">Основные</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active show"  id="sub-tab_{{ $lang->key }}-index" role="tabpanel">
                  <div class="row">
                    <div class="col-sm-2 col-md-2 col-lg-1">
                      <div class="form-group">
                        <label>Показывать</label><br/>
                        <label class="switch switch-3d switch-primary">
                          <input name='services_good_{{ $lang->key }}' type='hidden' value='0'>
                          <input type="checkbox" class="switch-input" name="services_good_{{ $lang->key }}" value="1" @if (old('services_good_{{ $lang->key }}') == 1){{ 'checked' }}@elseif ($service->$good == 1){{ 'checked' }}@endif>
                          <span class="switch-label"></span>
                          <span class="switch-handle"></span>
                        </label>
                      </div>
                    </div>
                    <div class="col-sm-10 col-md-10 col-lg-11">
                      <div class="form-group">
                        <label>Ниаменование</label>
                        <input type="text" name="services_title_{{ $lang->key }}" class="form-control" value="@if(old('services_title_' . $lang->key )){{ old('services_title_' . $lang->key ) }}@else{{ $service->$title }}@endif">
                      </div>
                    </div>
                  </div>

                  <textarea name="services_description_{{ $lang->key }}" class="tinymce">@if(old('services_description_' . $lang->key )){{ old('services_description_' . $lang->key ) }}@else{{ $service->$description }}@endif</textarea>
                </div>
              </div>
            </div>
          @endforeach

          <div class="tab-pane"  id="adds" role="tabpanel">
            <div class="row">

              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Район</label>
                  <select class="form-control" name="services_region">
                    <option value="0">---</option>
                    @foreach (config('avl.regions') as $key => $value)
                      <option value="{{ $key }}" @if($service->region == $key){{ 'selected' }}@endif>{{ $value['ru'] }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-12 col-sm-6">
                <div class="form-group">
                  {{ Form::label(null, 'Координаты') }}
                  {{ Form::text('services_coords', $service->coords, ['class' => 'form-control', 'id' => 'services_coords', 'readonly' => true]) }}
                </div>
              </div>

              {{-- Адрес поля с переводом --}}

              <div class="col-12 mb-3">
                <ul class="nav nav-tabs" role="tablist">
                  @foreach($langs as $lang)
                    <li class="nav-item">
                      <a class="nav-link @if($lang->key == 'ru') active show @endif" href="#sub_tab_adds_{{ $lang->key }}" data-toggle="tab">{{ $lang->name }}</a>
                    </li>
                  @endforeach
                </ul>

                <div class="tab-content">
                  @foreach ($langs as $lang)
                    <div class="tab-pane @if($lang->key == 'ru') active show @endif" id="sub_tab_adds_{{ $lang->key }}" role="tabpanel">

                      <div class="row">
                        <div class="col-12 col-sm-6">
                          <div class="form-group">
                            {{ Form::label(null, 'Адрес') }}
                            {{ Form::text('services_address_' . $lang->key, $service->{'address_' . $lang->key}, ['class' => 'form-control']) }}
                          </div>
                        </div>

                        <div class="col-12 col-sm-6">
                          <div class="form-group">
                            {{ Form::label(null, 'Адрес согласно лицензии') }}
                            {{ Form::text('services_address_license_' . $lang->key,  $service->{'address_license_' . $lang->key}, ['class' => 'form-control']) }}
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>

              </div>

              <div class="col-12">
                <div id="map" style="width: 100%; height: 400px"></div>
              </div>

            </div>
          </div>

          <div class="tab-pane" id="tab--attributes" role="tabpanel">

            <div class="row">

              <div class="col-sm-12 col-md-4 col-lg-4">
                {{ Form::label(null, 'Язык обучения (для школ)') }}
                <ul class="list-group">
                  @foreach (trans('configuration.langs') as $key => $value)
                    <li class="list-group-item">
                      <label class="m-0">
                        <input type="checkbox" name="services_langs[]" value="{{ $key }}"
                          @if (!is_null($service->langs))
                            @if(in_array($key, $service->langs)){{ 'checked' }}@endif
                          @endif
                        > {{ $value }}
                      </label>
                    </li>
                  @endforeach
                </ul>
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      {{ Form::label(null, 'Руководитель') }}
                      <ul class="nav nav-tabs" role="tablist">
                        @foreach($langs as $lang)
                          <li class="nav-item">
                            <a class="nav-link @if($lang->key == 'ru') active show @endif" href="#sub_tab_head_{{ $lang->key }}" data-toggle="tab">{{ $lang->name }}</a>
                          </li>
                        @endforeach
                      </ul>

                      <div class="tab-content">
                        @foreach ($langs as $lang)
                          <div class="tab-pane @if($lang->key == 'ru') active show @endif" id="sub_tab_head_{{ $lang->key }}" role="tabpanel">
                            {{ Form::text('services_head_' . $lang->key, $service->{'head_' . $lang->key}, ['class' => 'form-control']) }}
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  {{ Form::label(null, 'Телефоны') }}
                  {{ Form::text('services_phone', $service->phone, ['class' => 'form-control']) }}
                </div>

              </div>

              <div class="col-sm-12 col-md-4 col-lg-4">

                <div class="form-group">
                  {{ Form::label(null, 'E-mail') }}
                  {{ Form::text('services_email', $service->email, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                  {{ Form::label(null, 'Тип (для школ)') }}
                  {{ Form::select('services_type', trans('configuration.type_school'), $service->type, ['class' => 'form-control', 'placeholder' => '---']) }}
                </div>

              </div>
            </div>

          </div>

        </div>

      {{ Form::close() }}
    </div>

    <div class="card-footer position-relative">
        <i class="fa fa-align-justify"></i> Редактирование: {{ $service->title }}
        <div class="card-actions">
          <a href="{{ route('admin.settings.sections.services.store', ['id' => $section->id]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить и перейти к списку"><i class="fa fa-floppy-o"></i></button>
        </div>
    </div>
  </div>
@endsection
