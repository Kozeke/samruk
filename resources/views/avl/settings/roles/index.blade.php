@extends('avl.default')

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Настройка ролей
            @can('create', $accessModel)
              <div class="card-actions">
                <a href="{{ url('/admin/settings/roles/create') }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
              </div>
            @endcan
        </div>
        <div class="card-body">
            @if ($roles)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Роль</th>
                            <th class="text-center" style="width: 160px">Создано</th>
                            <th class="text-center" style="width: 100px;">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                          <tr class="position-relative" id="role--{{ $role->id }}">
                              <td>{{ $role->name }} <br/><small><i>{{ $role->display_name }}</i></small></td>
                              <td>{{ $role->created_at }}</td>
                              <td class="text-right">
                                @if ($role->name != 'admin')
                                  <div class="btn-group" role="group">
                                    @can('view', $accessModel) <a href="{{ route('admin.settings.roles.show', ['roles' => $role->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan
                                    @can('update', $accessModel) <a href="{{ route('admin.settings.roles.edit', ['roles' => $role->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a> @endcan
                                    @can('delete', $accessModel) <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a> @endcan
                                  </div>
                                  @can('delete', $accessModel)
                                    <div class="remove-message">
                                        <span>Вы действительно желаете удалить запись?</span>
                                        <span class="remove--actions btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
                                            <button class="btn btn-outline-danger remove--role" data-id="{{ $role->id }}"><i class="fa fa-trash"></i> Да</button>
                                        </span>
                                    </div>
                                   @endcan
                                 @endif
                              </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $roles->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')

    <script src="/avl/js/modules/settings/roles/roles.js" charset="utf-8"></script>

@endsection
