@extends('avl.default')

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Пользователи
            @can('create', $accessModel)
              <div class="card-actions">
                <a href="{{ url('/admin/settings/users/create') }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
              </div>
            @endcan
        </div>
        <div class="card-body">
            @if ($users)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 25px"></th>
                            <th>Пользователи</th>
                            <th>Роли пользователей</th>
                            <th class="text-center" style="width: 160px">Создан</th>
                            <th class="text-center" style="width: 100px;">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                          <tr class="position-relative">
                            <td class="text-center">
                              <a href="#" class="change--status" data-id="{{ $user->id }}" data-model="User">@if ($user->good == 1)<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i>@endif</a>
                            </td>
                            <td>{{ $user->fio }}<br/><small><i>{{ $user->email }}</i></small></td>
                            <td>@if($user->role){{ $user->role->display_name }}@else <i style="color:red;">Роль не назначена</i> @endif</td>
                            <td>{{ $user->created_at }}</td>
                            <td class="text-right">
                              <div class="btn-group" role="group">
                                @can('view', $accessModel) <a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan
                                @can('update', $accessModel) <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a> @endcan
                                @can('delete', $accessModel) <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a> @endcan
                              </div>
                              @can('delete', $accessModel)
                                <div class="remove-message">
                                    <span>Вы действительно желаете удалить запись?</span>
                                    <span class="remove--actions btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
                                        <button class="btn btn-outline-danger remove" data-id="{{ $user->id }}"><i class="fa fa-trash"></i> Да</button>
                                    </span>
                                </div>
                               @endcan
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $users->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')

    <script src="/avl/js/modules/settings/roles/roles.js" charset="utf-8"></script>

@endsection
