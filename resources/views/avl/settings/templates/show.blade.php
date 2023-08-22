@extends('avl.default')

@section('main')
  <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Просмотр шаблона
          <div class="card-actions">
              <a href="{{ url('/admin/settings/templates') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          </div>
      </div>
      <div class="card-body">
        @if ($template)
          <div class="form-group">
              <label for="template_name">Название</label>
              <span class="form-control">{{ $template->title }}</span>
          </div>
          <div class="form-group">
              <label for="template_template">Тип шаблона</label>
              <span class="form-control">{{ config('avl.sections.'. $template->template) }}</span>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="template_records">Кол-во записей на странице</label>
                    <span class="form-control">{{ $template->records }}</span>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="template_sorting">Сортировка записей на странице</label>
                    @foreach (config('avl.sorts') as $key => $sort)
                      @if($template->sorting == $key)
                        <span class="form-control">{{ $sort }}</span>
                      @endif
                    @endforeach
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
                      <span class="form-control">{{ $template->records_col }}</span>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="template_sorting_col">Сортировка записей в колонке</label>
                      @foreach (config('avl.sorts') as $key => $sort)
                        @if($template->sorting_col == $key)
                          <span class="form-control">{{ $sort }}</span>
                        @endif
                      @endforeach
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
                <span class="form-control">{{ $template->file_short }}</span>
              </div>
            </div>
            <div class="col-lg-3 col-sm-12">
              <div class="form-group">
                <label for="template_file_full">Шаблон для вывода полной записи</label>
                <span class="form-control">{{ $template->file_full }}</span>
              </div>
            </div>
            <div class="col-lg-3 col-sm-12">
              <div class="form-group">
                <label for="template_file_col">Шаблон для вывода вывода колонки</label>
                <span class="form-control">{{ $template->file_col }}</span>
              </div>
            </div>
            <div class="col-lg-3 col-sm-12">
              <div class="form-group">
                <label for="template_file_category">Шаблон для вывода категории</label>
                <span class="form-control">{{ $template->file_category }}</span>
              </div>
            </div>
          </div>
        @endif
      </div>
  </div>
@endsection
