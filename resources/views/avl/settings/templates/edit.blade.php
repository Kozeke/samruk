@extends('avl.default')

@section('main')
  <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Редактирование шаблона
          <div class="card-actions">
            <a href="{{ url('/admin/settings/templates') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
          </div>
      </div>
      <div class="card-body">
          <form action="{{ url('/admin/settings/templates/'.$template->id) }}" method="post" id="submit">
            {!! csrf_field(); !!}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="template_name">Название</label>
                <input type="text" id="template_name" name="template_name" class="form-control" value="@if(old('template_name')){{ old('template_name') }}@else{{ $template->title }}@endif">
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="template_records">Кол-во записей на странице</label>
                      <input type="text" id="template_records" name="template_records" class="form-control" value="@if(old('template_records')){{ old('template_records') }}@else{{ $template->records }}@endif" placeholder="10">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="template_sorting">Сортировка записей на странице</label>
                      <select id="template_sorting" class="form-control" name="template_sorting">
                        @foreach (config('avl.sorts') as $key => $sort)
                          <option value="{{ $key }}" @if(old('template_sorting') == $key) selected="" @elseif($template->sorting == $key) selected="" @endif>{{ $sort }}</option>
                        @endforeach
                     </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12"><hr/></div>
              <div class="col-lg-12">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="template_records_col">Кол-во записей в колонке</label>
                        <input type="text" id="template_records_col" name="template_records_col" class="form-control" value="@if(old('template_records_col')){{ old('template_records_col') }}@else{{ $template->records_col }}@endif" placeholder="5">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="template_sorting_col">Сортировка записей в колонке</label>
                        <select id="template_sorting_col" class="form-control" name="template_sorting_col">
                          @foreach (config('avl.sorts') as $key => $sort)
                            <option value="{{ $key }}" @if(old('template_sorting_col') == $key) selected="" @elseif($template->sorting_col == $key) selected="" @endif>{{ $sort }}</option>
                          @endforeach
                       </select>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12"><hr/></div>
              <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                  <label for="template_file_short">Шаблон для вывода короткой записи</label>
                  <select id="template_file_short" class="form-control" name="template_file_short">
                    <option value="0">Выберите шаблон</option>
                    @foreach ($shortFiles as $shortFile)
                      <option value="{{ $shortFile->getFilename() }}" @if(old('template_file_short') == $shortFile->getFilename()) selected="" @elseif($template->file_short == $shortFile->getFilename()) selected="" @endif>{{ $shortFile->getFilename() }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                  <label for="template_file_full">Шаблон для вывода полной записи</label>
                  <select id="template_file_full" class="form-control" name="template_file_full">
                    <option value="0">Выберите шаблон</option>
                    @foreach ($fullFiles as $fullFile)
                    <option value="{{ $fullFile->getFilename() }}" @if(old('template_file_full') == $fullFile->getFilename()) selected="" @elseif($template->file_full == $fullFile->getFilename()) selected="" @endif>{{ $fullFile->getFilename() }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                  <label for="template_file_col">Шаблон для вывода вывода колонки</label>
                  <select id="template_file_col" class="form-control" name="template_file_col">
                    <option value="0">Выберите шаблон</option>
                    @foreach ($colFiles as $colFile)
                    <option value="{{ $colFile->getFilename() }}" @if(old('template_file_col') == $colFile->getFilename()) selected="" @elseif($template->file_col == $colFile->getFilename()) selected="" @endif>{{ $colFile->getFilename() }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                  <label for="template_file_category">Шаблон для вывода категории</label>
                  <select id="template_file_category" class="form-control" name="template_file_category">
                    <option value="0">Выберите шаблон</option>
                    @foreach ($categoryFiles as $categoryFile)
                    <option value="{{ $categoryFile->getFilename() }}" @if(old('template_file_category') == $categoryFile->getFilename()) selected="" @elseif($template->file_category == $categoryFile->getFilename()) selected="" @endif>{{ $categoryFile->getFilename() }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </form>
      </div>
  </div>
@endsection
