@extends('avl.default')

@section('main')
  <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Добавление языков
          <div class="card-actions">
            <a href="{{ url('/admin/settings/langs') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
          </div>
      </div>
      <div class="card-body">
          <form action="{{ url('/admin/settings/langs') }}" method="post" id="submit">
              {!! csrf_field(); !!}
              <div class="form-group">
                  <label for="langs--select_key">Выберите язык</label>
                  <select id="langs--select_key" class="form-control" name="lang_key">
                    <option value="">Выберите язык из списка</option>
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                      @if (!in_array($localeCode, $existLangs))
                        <option value="{{ $localeCode }}" @if(old('lang_key') == $localeCode) selected @endif>{{ $properties['name'] }}</option>
                      @endif
                    @endforeach
                  </select>
              </div>
              <div class="form-group">
                <label for="langs--select_name">Название для отображения</label>
                <input id="langs--select_name" class="form-control" type="text" name="lang_name" value="{{ old('lang_name') }}">
              </div>
          </form>
      </div>
  </div>
@endsection
