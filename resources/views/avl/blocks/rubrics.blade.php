@foreach ($sections as $section)
  <li class="list-group-item sections--tree-name">
    @if($level > 0)<span class="delimetr">{{ delimetr($pre, $level) }}</span>@endif
    <span>
      @if ($section['rubric'] == 0)
        {{ $section['name_ru'] }}
      @else
        <a href="{{ route('admin.site.settings.rubrics.index', ['id' => $section['id']]) }}">{{ $section['name_ru'] }}</a>
      @endif
    </span>
  </li>
  @if(count($section['children']) > 0)
    @include('avl.blocks.rubrics', ['sections' => $section['children'], 'pre' => '&#8594; ', 'level' => $level + 1 ])
  @endif
@endforeach
