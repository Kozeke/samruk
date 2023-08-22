@extends('avl.default')

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Настройка районов

              <div class="card-actions">
                <a href="{{ route('admin.settings.configurations.areas.create') }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
              </div>
        </div>
        <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 25px">#</th>
                            <th class="text-center" style="width: 25px">Вкл</th>
                            <th>Район</th>
                            @if ($langs->count() > 0)
                              @foreach ($langs as $lang)
                                @if ($lang->key != 'ru')
                                  <th class="text-center" style="width: 25px"><img src="/avl/img/icons/flags/{{ $lang->key }}--16.png" alt=""></th>
                                @endif
                              @endforeach
                            @endif
                            <th>Алиас</th>
                            <th class="text-center" style="width: 160px">Создан</th>
                            <th class="text-center" style="width: 100px;">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if ($records->count() > 0)
                        @foreach ($records as $record)
                          <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                              <a class="change--status" href="#" data-id="{{ $record->id }}" data-model="Areas">@if ($record->good)<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i> @endif</a>
                            </td>
                            <td>{{ $record->title }}</td>
                            @if ($langs->count() > 0)
                              @foreach ($langs as $lang)
                                @if ($lang->key != 'ru')
                                  <td class="text-center">{!! config('avl.goodBange.' . (($record->{'title_'. $lang->key} == '') ? 0 : 1 ) ) !!}</td>
                                @endif
                              @endforeach
                            @endif
                            <td>{{ $record->alias }}</td>
                            <td>{{ $record->created_at }}</td>
                            <td>
                              <div class="btn-group" role="group">
                                @can('view', new App\Models\Areas) <a href="{{ route('admin.settings.configurations.areas.show', ['area' => $record->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan
                                @can('update', new App\Models\Areas)
                                  <a href="{{ route('admin.settings.configurations.areas.edit', ['area' => $record->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a>
                                @endcan
                                @if ($record->id != 1)
                                  @can('delete', new App\Models\Areas) <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a> @endcan
                                @endif
                              </div>
                              @if ($record->id != 1)
                                @can('delete', new App\Models\Areas)
                                  <div class="remove-message">
                                      <span>Вы действительно желаете удалить запись?</span>
                                      <span class="remove--actions btn-group btn-group-sm">
                                          <button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
                                          <button class="btn btn-outline-danger remove" data-id="{{ $record->id }}"><i class="fa fa-trash"></i> Да</button>
                                      </span>
                                  </div>
                                 @endcan
                               @endif
                            </td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                </table>
        </div>
    </div>
@endsection
