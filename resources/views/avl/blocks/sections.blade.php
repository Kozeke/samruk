<ul class="menu-list">
  @foreach ($structures as $structure)
    @if ($structure['good'] == 1)
      <li class="menu-list-item" id="menu-list-item-{{ $structure['id'] }}">
        <div class="menu-item @if(count($structure['children']) > 0){{ 'has-submenu' }}@endif">
          <a class="menu-link" href="/admin/settings/sections/{{ $structure['id'] }}/{{ $structure['type'] }}">{{ $structure['name_ru'] }}</a>
          @if(count($structure['children']) > 0)
            <a class="toggler" href="#" data-id="{{ $structure['id'] }}">Раскрыть</a>
          @endif
        </div>
        @if(count($structure['children']) > 0)
          @include('avl.blocks.sections', ['structures' => $structure['children'], 'level' => $level + 1 ])
        @endif
      </li>
    @endif
  @endforeach
</ul>
