@extends('avl.default')

@section('js')
  <script src="/avl/js/modules/settings/sections/section.js" charset="utf-8"></script>
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Структура
            @can('create', $accessModel)
              <div class="card-actions">
                <a href="{{ url('/admin/settings/sections/create') }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
              </div>
            @endcan
        </div>
        <div class="card-body">
            @if ($sections)
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th class="text-center" style="width: 25px">Вкл</th>
                          <th class="text-center" style="width: 25px">Меню</th>
                          @can('update', $accessModel) <th class="text-center" style="width: 110px">Порядок</th> @endcan
                          <th>Наименование</th>
                          @if ($langs->count() > 0)
                            @foreach ($langs as $lang)
                              <th class="text-center"><img src="/avl/img/icons/flags/{{ $lang->key }}--16.png" alt=""></th>
                            @endforeach
                          @endif
                          <th>Алиас</th>
                          <th class="text-center" style="width: 160px">Создан</th>
                          <th class="text-center" style="width: 100px;">Действие</th>
                      </tr>
                  </thead>
                  <tbody>
                      @include('avl.settings.sections.blocks.index', ['sections' => $sections, 'pre' => '', 'level' => 0])
                  </tbody>
                </table>
              </div>
            @endif
        </div>
    </div>
@endsection
