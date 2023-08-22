@foreach ($structures as $structure)
  @if ($structure['good'] == 1)
    <option value="{{ $structure['id'] }}">{{ str_repeat('&middot; ', $level) }} {{ $structure['name_ru'] }}</option>
    @if(count($structure['children']) > 0)
      @include('avl.blocks.sections_importer', ['structures' => $structure['children'], 'level' => $level + 1 ])
    @endif
  @endif
@endforeach
