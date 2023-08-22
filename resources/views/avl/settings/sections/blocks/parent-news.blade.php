@foreach ($sections as $section)
  <option @if($section['type'] == 'news') value="{{ $section['id'] }}" @else disabled @endif >{{ delimetr($pre, $level) }} {{ $section['name_ru'] }}</option>

  @if(count($section['children']) > 0)
    @include('avl.settings.sections.blocks.parent-news', ['sections' => $section['children'], 'parent' => $parent, 'current' => $current, 'pre' => '&#8594; ', 'level' => $level + 1 ])
  @endif
@endforeach
