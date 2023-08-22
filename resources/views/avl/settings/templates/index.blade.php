@extends('avl.default')

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Настройка шаблонов
            @can('create', App\Models\Templates::class)
              <div class="card-actions">
                <a href="{{ url('/admin/settings/templates/create') }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
              </div>
            @endcan
        </div>
        <div class="card-body">
          @if ($templates)
            <div class="row">
              @foreach (config('avl.sections') as $key => $name)
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      Тип - {{ $name }}
                    </div>
                    <div class="card-body">
                      <ul class="list-group">
                        @foreach($templates as $template)
                          @if ($template->template == $key)
                            <li id="template--{{ $template->id }}" class="list-group-item list-group-item-action">
                              {{ $template->title }}
                              <div class="btn-group btn-group-sm pull-right" role="group">
                                <a href="{{ route('admin.settings.templates.show', ['templates' => $template->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('admin.settings.templates.edit', ['templates' => $template->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a>
                                @if ($template->ban == 0)
                                  <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a>
                                @endif
                              </div>
                              @can('delete', new App\Models\Templates)
                                <div class="remove-message">
                                    <span>Вы действительно желаете удалить запись?</span>
                                    <span class="remove--actions btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
                                        <button class="btn btn-outline-danger removeTemplate" data-id="{{ $template->id }}"><i class="fa fa-trash"></i> Да</button>
                                    </span>
                                </div>
                               @endcan
                            </li>
                          @endif
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/modules/settings/templates/index.js" charset="utf-8"></script>
@endsection
