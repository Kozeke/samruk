@foreach ($sections as $section)
  <option value="{{ $section['id'] }}" @if ($section['id'] == $parent) selected="" @endif>{{ delimetr($pre, $level) }} {{ $section['name_ru'] }}</option>

  @if ($current != $section['id'])
    @if(count($section['children']) > 0)
      @include('avl.settings.sections.blocks.parent', ['sections' => $section['children'], 'parent' => $parent, 'current' => $current, 'pre' => '&#8594; ', 'level' => $level + 1 ])
    @endif
  @endif
@endforeach
