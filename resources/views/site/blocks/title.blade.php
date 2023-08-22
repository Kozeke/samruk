@if (isset($section) && $section)
	<h1 class="title-page{{ isset($titleClass) ? ' ' . $titleClass : '' }}">{{ $section->name }}</h1>
@elseif (isset($title))
	<h1 class="title-page{{ isset($titleClass) ? ' ' . $titleClass : '' }}">{{ $titleName }}</h1>
@endif
