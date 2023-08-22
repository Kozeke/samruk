@extends('avl.default')

@section('main')
  <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Редактирование роли
          <div class="card-actions">
            <a href="{{ url('/admin/settings/roles') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
            <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
          </div>
      </div>
      <div class="card-body">
          <form action="{{ url('/admin/settings/roles/'.$role->id) }}" method="post" id="submit">
            {!! csrf_field(); !!}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="avl-name">Имя</label>
                <span class="form-control bg-light">{{ $role->name }}</span>
            </div>
            <div class="form-group">
              {{ Form::label(null, 'Имя для отображения') }}
              {{ Form::text('role_display_name', $role->display_name ?? null, ['class' => 'form-control']) }}
            </div>
          <div class="row">
            <div class="col-12">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active show" href="#common" data-toggle="tab">Основное меню</a></li>
                <li class="nav-item"><a class="nav-link" href="#strucure" data-toggle="tab">Структура</a></li>
              </ul>
              <div class="tab-content">

                <div class="tab-pane active show"  id="common" role="tabpanel">
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
                                        name="permission[{{ 'App\Models\Menu' }}][{{ $menu->id }}][{{ $key }}]"
                                      @if (isset($permissions['App\Models\Menu']))
                                        @if (array_key_exists($menu->id, $permissions['App\Models\Menu']))
                                          @if($permissions['App\Models\Menu'][$menu->id][$key] == 1)
                                            checked=""
                                          @endif
                                        @elseif (isset($permissions['App\Models\Menu'][$key]))
                                          @if (!is_null($permissions['App\Models\Menu'][$key]))
                                            checked=""
                                          @endif
                                        @endif
                                      @endif
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

                <div class="tab-pane"  id="strucure" role="tabpanel">
                  <table class="table table-responsive-sm table-striped table-bordered">
                    <thead>
                      <th>Раздел</th>
                      <th class="text-center"><a href="#" class="check-all unchecked" data-type="read">Просмотр</a></th>
                      <th class="text-center"><a href="#" class="check-all unchecked" data-type="add">Добавление</a></th>
                      <th class="text-center"><a href="#" class="check-all unchecked" data-type="edit">Редактирование</a></th>
                      <th class="text-center"><a href="#" class="check-all unchecked" data-type="delete">Удаление</a></th>
                    </thead>
                    <tbody>
                      @include('avl.settings.roles.structures', ['sections' => $structures, 'pre' => '', 'level' => 0])
                    </tbody>
                  </table>
                </div>

              </div>

            </div>
          </div>


          </form>
      </div>
  </div>
@endsection

@section('js')
  <script src="/avl/js/modules/settings/roles/roles.js" charset="utf-8"></script>
@endsection
