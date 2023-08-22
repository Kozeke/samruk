@extends('avl.default')

@section('js')
  <link rel="stylesheet" href="/avl/js/datetimepicker/jquery.datetimepicker.css">
  <script src="/avl/js/dateformat.js" charset="utf-8"></script>
  <script src="/avl/js/datetimepicker/build/jquery.datetimepicker.full.min.js" charset="utf-8"></script>

  <script src="/avl/js/modules/settings/news/index.js" charset="utf-8"></script>
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> {{$section->name_ru}}
            @can('create', $section)
              <div class="card-actions">
                <a href="{{ url('/admin/settings/sections/'.$id.'/news/create') }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
              </div>
            @endcan
        </div>
        <div class="card-body" style="owerflow:hidden; owerflow-x: true;">

          @if (!is_null($section->rubric))
            <form action="" method="get" class="mb-4">
              <div class="row">
                <div class="col-10">
                  {{ Form::select('rubric', $rubrics, $request->input('rubric'), ['placeholder' => 'Все новости', 'class' => 'form-control']) }}
                </div>
                <div class="col-2">
                  <button type="submit" class="btn btn-primary w-100">Показать</button>
                </div>
              </div>
            </form>
          @endif

            @if ($news)
                @php $iteration = 30 * ($news->currentPage() - 1); @endphp
                <table class="table table-bordered">
                    <thead>
                      <tr>
                          <th width="50" class="text-center">#</th>
                          @foreach($langs as $lang)
                            <th class="text-center" style="width: 20px">{{ $lang->key }}</th>
                          @endforeach
                          @if ($section->alias == 'news')
                            <th class="text-center" style="width: 20px"><i class="fa fa-check-circle-o"></i></th>
                          @endif
                          <th class="text-center">Наименование новости</th>
                          @if($section->rubric == 1)<th class="text-center" style="width: 160px;">Рубрика</th>@endif
                          <th class="text-center" style="width: 160px">Дата публикации</th>
                          <th class="text-center" style="width: 100px;">Действие</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $new)
                          <tr class="position-relative" id="news--item-{{ $new->id }}">
                            <td class="text-center">{{ ++$iteration }}</td>
                            @foreach($langs as $lang)
                              <td class="text-center" style="width: 20px">
                                <a class="change--status" href="#" data-id="{{ $new->id }}" data-model="News" data-lang="{{$lang->key}}">@if ($new->{'good_' . $lang->key})<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i> @endif</a>
                              </td>
                            @endforeach
                            @if ($section->alias == 'news')
                              <td class="text-center" style="width: 20px">
                                <a class="change--fixed" href="#" data-id="{{ $new->id }}">
                                  <i class="fa @if ($new->fixed){{ 'fa-check-circle-o' }}@else{{ 'fa-circle-o' }}@endif"></i>
                                </a>
                              </td>
                            @endif
                            <td><b>{{ $new->title_ru }}</b><br/><span class="text-secondary">{{ str_limit(strip_tags($new->short_ru), 300) }}</span></td>
                            @if($section->rubric == 1)
                              <td class="text-center">@if(!is_null($new->rubric))@if(!is_null($new->rubric->title_ru)){{ $new->rubric->title_ru }}@else{{ str_limit(strip_tags($new->rubric->description_ru), 70) }}@endif @endif</td>
                            @endif
                            <td class="text-center change--datetime">
                              <span>{{ date('Y-m-d H:i', strtotime($new->published_at)) }}</span>
                              <input type="text" class="datetimepicker form-control" data-id="{{ $new->id }}" value="{{ date('Y-m-d H:i', strtotime($new->published_at)) }}">
                            </td>
                            <td class="text-right">
                              <div class="btn-group" role="group">
                                @can('view', $section) <a href="{{ route('news.show', ['id' => $id, 'news_id' => $new->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan
                                @can('update', $section) <a href="{{ route('news.edit', ['id' => $id, 'news_id' => $new->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a> @endcan
                                @can('update', $section) <a href="{{ route('admin.settings.sections.news.move', ['id' => $id, 'nws' => $new->id]) }}" class="btn btn btn-outline-secondary" title="Изменить"><i class="fa fa-arrows"></i></a> @endcan
                                @can('delete', $section) <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a> @endcan
                              </div>
                              @can('delete', $section)
                                <div class="remove-message">
                                    <span>Вы действительно желаете удалить запись?</span>
                                    <span class="remove--actions btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
                                        <button class="btn btn-outline-danger remove--news" data-id="{{ $new->id }}" data-section="{{ $id }}"><i class="fa fa-trash"></i> Да</button>
                                    </span>
                                </div>
                               @endcan
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $news->appends($_GET)->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
