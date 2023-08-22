@foreach ($areaStructures as $areaStructure)
  <option
		@if($areaStructure['type'] == 'news')
			value="{{ $areaStructure['id'] }}"
			@if ($areaStructure['id'] == $current){{ 'selected' }}@endif
		@else
			disabled
		@endif
	>
		{{ delimetr($pre, $level) }} {{ $areaStructure['name_ru'] }}
	</option>

  @if(count($areaStructure['children']) > 0)
    @include('avl.settings.sections.blocks.area-structures', ['areaStructures' => $areaStructure['children'], 'parent' => $parent, 'current' => $current, 'pre' => '&#8594; ', 'level' => $level + 1 ])
  @endif
@endforeach
