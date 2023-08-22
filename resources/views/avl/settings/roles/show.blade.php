@extends('avl.default')

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Просмотр роли
            <div class="card-actions">
                <a href="{{ url('/admin/settings/roles') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="avl-name">Имя</label>
            <span class="form-control">{{ $role->name }}</span>
          </div>
          <div class="form-group">
            <label for="display_name">Имя для отображения</label>
            <span class="form-control">{{ $role->display_name }}</span>
          </div>
            @if ($role->name != 'admin')
              @if ($menus)
                <div class="row">
                  @foreach ($menus as $menu)
                    <div class="col-lg-3">
                      <h5>{{ $menu->title }}</h5>
                      <ul class="list-unstyled ml-3 mt-1">
                        @foreach (config('avl.permissions') as $key => $permission)
                          <li>
                            <label class="switch switch-text switch-primary-outline-alt switch-sm">
                              <input type="checkbox" class="switch-input" value="1"
                                @if (isset($permissions[$menu->model]))
                                  @if (array_key_exists($menu->id, $permissions[$menu->model]))
                                    @if($permissions[$menu->model][$menu->id][$key] == 1)
                                      checked=""
                                    @endif
                                  @elseif (isset($permissions[$menu->model][$key]))
                                    @if (!is_null($permissions[$menu->model][$key]))
                                      checked=""
                                    @endif
                                  @endif
                                @endif
                                disabled=""
                                >
                              <span class="switch-label" data-on="On" data-off="Off"></span>
                              <span class="switch-handle"></span>
                            </label>
                            {{ $permission }}
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  @endforeach
                </div>
              @endif
            @endif
        </div>
    </div>
@endsection
