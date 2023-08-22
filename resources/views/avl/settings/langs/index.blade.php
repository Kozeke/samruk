@extends('avl.default')

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Найстройка языков
            @can('create', App\Models\Langs::class)
              <div class="card-actions">
                <a href="#" class="w-50 pl-3 pr-3 refresh"><i class="fa fa-refresh refresh"></i> Обновить</a>
                <a href="{{ url('/admin/settings/langs/create') }}" class="w-50 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
              </div>
            @endcan
        </div>
        <div class="card-body">
            @if ($langs)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:20px;">Код</th>
                            <th style="width:20px;" class="text-center">Вкл</th>
                            <th>Язык</th>
                            <th class="text-center" style="width: 160px">Создано</th>
                            <th class="text-center" style="width: 100px;">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($langs as $lang)
                          <tr class="position-relative" id="lang--item-{{ $lang->id }}">
                              <td class="text-center">{{ $lang->key }}</td>
                              <td class="text-center">
                                <a class="change--status" href="#" data-id="{{ $lang->id }}" data-model="Langs">@if ($lang->good)<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i> @endif</a>
                              </td>
                              <td>{{ $lang->name }}</td>
                              <td>{{ $lang->created_at }}</td>
                              <td class="text-right">
                                <div class="btn-group" role="group">
                                  @can('view',   new App\Models\Langs) <a href="{{ route('langs.show', ['langs' => $lang->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan
                                  @can('update', new App\Models\Langs) <a href="{{ route('langs.edit', ['langs' => $lang->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a> @endcan
                                  @can('delete', new App\Models\Langs) <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a> @endcan
                                </div>
                                @can('delete', $lang)
                                  <div class="remove-message">
                                      <span>Вы действительно желаете удалить запись?</span>
                                      <span class="remove--actions btn-group btn-group-sm">
                                          <button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
                                          <button class="btn btn-outline-danger removeLang" data-id="{{ $lang->id }}"><i class="fa fa-trash"></i> Да</button>
                                      </span>
                                  </div>
                                 @endcan
                              </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $langs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/modules/settings/langs/index.js" charset="utf-8"></script>
@endsection
