@foreach ($sections as $section)
  <tr class="position-relative" id="section--item-{{ $section['id'] }}">
    <td class="text-center">
      <a href="#" @can('update', $accessModel) class="change--status" data-id="{{ $section['id'] }}" data-model="Sections" @endcan>@if ($section['good'] == 1)<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i>@endif</a>
    </td>
    <td class="text-center">
      <a href="#" @can('update', $accessModel) class="change--status-menu" data-id="{{ $section['id'] }}" @endcan>@if ($section['menu'] == 1)<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i>@endif</a>
    </td>
    @can('update', $accessModel)
      <td class="text-center">
        <div class="input-group">
          <input type="text" class="form-control" id="change--order-{{ $section['id'] }}" value="{{ $section['order'] }}" autocomplete="off">
          <div class="input-group-append">
            <a class="input-group-text change--order" data-id="{{ $section['id'] }}" href="#"><i class="fa fa-floppy-o"></i></a>
          </div>
        </div>
      </td>
    @endcan
    <td>
      <div class="sections--tree-name">
        @if($level > 0)<span class="delimetr">{{ delimetr($pre, $level) }}</span>@endif
        <span>
          {{ $section['name_ru'] }} <br/>
          <span class="template">
            {{ config('avl.sections.' . $section['type']) }}:
            <span class="text-secondary"><a href="{{ route('admin.settings.templates.edit', ['templates' => $section['template_id']]) }}" style="color: inherit;">{{ $section['template'] }}</a></span>
          </span>
        </span>
      </div>
    </td>
    @if ($langs->count() > 0)
      @foreach ($langs as $lang)
        <td class="text-center">{!! config('avl.goodBange.' . (($section['name_' . $lang->key] == '') ? 0 : 1 ) ) !!}</td>
      @endforeach
    @endif
    <td>{{ $section['alias'] }}</td>
    <td>{{ $section['created_at'] }}</td>
    <td class="text-right">
      <div class="btn-group" role="group">
        @can('view', $accessModel) <a href="{{ route('admin.settings.sections.show', ['section' => $section['id']]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan
        @can('update', $accessModel)
          <a href="{{ route('admin.settings.sections.configuration', ['section' => $section['id']]) }}" class="btn btn btn-outline-secondary" title="Дополнительные настройки"><i class="fa fa-cogs"></i></a>
          <a href="{{ route('admin.settings.sections.edit', ['section' => $section['id']]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a>
        @endcan
        @can('delete', $accessModel) <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a> @endcan
      </div>
      @can('delete', $accessModel)
        <div class="remove-message">
            <span>Вы действительно желаете удалить раздел со всеми подразделами?</span>
            <span class="remove--actions btn-group btn-group-sm">
                <button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
                <button class="btn btn-outline-danger remove--section" data-id="{{ $section['id'] }}"><i class="fa fa-trash"></i> Да</button>
            </span>
        </div>
       @endcan
    </td>
  </tr>
  @if(count($section['children']) > 0)
    @include('avl.settings.sections.blocks.index', ['sections' => $section['children'], 'pre' => '&#8594; ', 'level' => $level + 1 ])
  @endif
@endforeach
