@extends('avl.default')

@section('js')
  <script src="/avl/js/modules/settings/news/index.js" charset="utf-8"></script>
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> <b>{{ $section['name_ru'] }}</b> - настройка рубрик
          <div class="card-actions">
            <a href="{{ route('admin.site.settings.rubrics.lists') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            @can('create', App\Models\Rubrics::class)
              <a href="{{ route('admin.site.settings.rubrics.create', ['id' => $section['id']]) }}" class="btn btn-primary pl-3 pr-3" style="width: 120px;"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
            @endcan
          </div>
        </div>
        <div class="card-body">
            @if ($rubrics->count() > 0)
              <table class="table table-bordered">
                <thead>
                  <tr>
                    @foreach($langs as $lang)
                      <th class="text-center" style="width: 20px">{{ $lang->key }}</th>
                    @endforeach
                      <th class="text-center">Название</th>
                      <th class="text-center" style="width: 160px">Дата публикации</th>
                      <th class="text-center" style="width: 100px;">Действие</th>
                  </tr>
                </thead>
                  <tbody>
                      @foreach ($rubrics as $rubric)
                        <tr class="position-relative">
                          @foreach($langs as $lang)
                            @php $good = 'good_' . $lang->key; @endphp
                            <td class="text-center" style="width: 20px">
                              <a class="change--status" href="#" data-id="{{ $rubric->id }}" data-model="Rubrics" data-lang="{{$lang->key}}">@if ($rubric->$good)<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i> @endif</a>
                            </td>
                          @endforeach
                          <td>
                            @if(!is_null($rubric->title_ru)){{ $rubric->title_ru }} <br/> @endif
                            <span class="text-secondary">{{ str_limit(strip_tags($rubric->description_ru), 150) }}</span>
                          </td>
                          <td>{{ $rubric->published_at }}</td>
                          <td class="text-right">
                            <div class="btn-group" role="group">
                              @can('view', new App\Models\Rubrics) <a href="{{ route('admin.site.settings.rubrics.show', ['id' => $id, 'link_id' => $rubric->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan
                              @can('update', new App\Models\Rubrics) <a href="{{ route('admin.site.settings.rubrics.edit', ['id' => $id, 'link_id' => $rubric->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a> @endcan
                              {{-- @can('delete', new App\Models\Rubrics) <a href="#" class="btn btn btn-outline-danger" title="Удалить"><i class="fa fa-trash"></i></a> @endcan --}}
                            </div>
                            {{-- @can('delete', $rubric)
                              <div class="remove-message">
                                  <span>Вы действительно желаете удалить запись?</span>
                                  <span class="remove--actions btn-group btn-group-sm">
                                      <button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
                                      <button class="btn btn-outline-danger remove--news" data-id="{{ $rubric->id }}" data-section="{{ $id }}"><i class="fa fa-trash"></i> Да</button>
                                  </span>
                              </div>
                             @endcan --}}
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
              <div class="d-flex justify-content-end">
                  {{ $rubrics->links() }}
              </div>
            @else
              Нет рубрик
            @endif
        </div>
    </div>
@endsection
