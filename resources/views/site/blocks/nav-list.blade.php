<ul class="{{ $ulClass }}">
  @foreach ($structures as $structure)
    <li class="@if(count($structure['children']) > 0){{ 'has-subnav' }}@endif">
      @php $name = 'name_' . LaravelLocalization::getCurrentLocale(); @endphp

			@if($structure['type'] != 'link')
				<a href="/{{ LaravelLocalization::getCurrentLocale() }}{{ $structure['link'] ?? '' }}">
			@else
				<a
					@if((substr($structure['link'], 0, 7) == 'http://') || (substr($structure['link'], 0, 8) == 'https://'))
						{{ 'target="_blank"' }} href="{{ $structure['link'] }}"
					@else
						href="/{{ LaravelLocalization::getCurrentLocale() }}{{ $structure['link'] ?? '' }}"
					@endif>
			@endif
					{{ (isset($structure[$name]) && !is_null($structure[$name])) ? $structure[$name] : $structure['name_ru'] }}
				</a>

				@if (count($structure['children']) > 0 && $ulClass == 'nav__list js-nav-list')
					<span class="nav__toggle">{!! icon('icon--arrow-down') !!}</span>
				@endif

      @if(count($structure['children']) > 0)
        @include('site.blocks.nav-list', ['structures' => $structure['children'], 'ulClass' => 'nav__subnav' ])
      @endif
    </li>
  @endforeach
</ul>

{{--
<ul class="nav__list js-nav-list">
	<li><a href="#">Главная</a></li>

	<li class="has-subnav">
		<a href="#">Инвестиционная деятельность</a>

		<ul class="nav__subnav">
			<li><a href="#">Направление «Коммерческое жилье»</a></li>

			<li><a href="#">Правила отбора и рассмотрения проектов</a></li>

			<li class="has-subnav">
				<a href="#">Механизм поддержки частных застройщиков</a>

				<ul class="nav__subnav">
					<li><a href="#">Правила реализации активов</a></li>
					<li><a href="#">Направление «Арендное жилье»</a></li>
					<li><a href="#">Правила отбора и рассмотрения проектов</a></li>
					<li><a href="#">Механизмы рассмотрения и реализации проектов</a></li>
				</ul>
			</li>

			<li><a href="#">Девелопмент недвижимости</a></li>

			<li><a href="#">Управление проектами</a></li>
		</ul>
	</li>

	<li class="has-subnav">
		<a href="#">Проекты компании</a>

		<ul class="nav__subnav">
			<li><a href="#">Жилые</a></li>
			<li><a href="#">Промышленные</a></li>
			<li><a href="#">Инфраструктурные</a></li>
		</ul>
	</li>

	<li class="has-subnav">
		<a href="#">Устойчивое развитие</a>

		<ul class="nav__subnav">
			<li><a href="#">Общая информация</a></li>
			<li class="has-subnav">
				<a href="#">Документы по устойчивому развитию</a>

				<ul class="nav__subnav">
					<li><a href="#">Политика</a></li>
					<li><a href="#">Карта стейкхолдеров</a></li>
					<li><a href="#">Отчеты об устойчивом развитии</a></li>
				</ul>
			</li>
			<li><a href="#">Взаимодействие с заинтересованными сторонами</a></li>
		</ul>
	</li>

	<li class="has-subnav">
		<a href="#">Проекты компании</a>

		<ul class="nav__subnav">
			<li><a href="#">Жилые</a></li>
			<li><a href="#">Промышленные</a></li>
			<li><a href="#">Инфраструктурные</a></li>
		</ul>
	</li>

	<li class="has-subnav">
		<a href="#">Инвестиционная деятельность</a>

		<ul class="nav__subnav">
			<li><a href="#">Направление «Коммерческое жилье»</a></li>

			<li><a href="#">Правила отбора и рассмотрения проектов</a></li>

			<li class="has-subnav">
				<a href="#">Механизм поддержки частных застройщиков</a>

				<ul class="nav__subnav">
					<li><a href="#">Правила реализации активов</a></li>
					<li><a href="#">Направление «Арендное жилье»</a></li>
					<li><a href="#">Правила отбора и рассмотрения проектов</a></li>
					<li><a href="#">Механизмы рассмотрения и реализации проектов</a></li>
				</ul>
			</li>

			<li><a href="#">Девелопмент недвижимости</a></li>

			<li><a href="#">Управление проектами</a></li>
		</ul>
	</li>

	<li class="has-subnav">
		<a href="#">Проекты компании</a>

		<ul class="nav__subnav">
			<li><a href="#">Жилые</a></li>
			<li><a href="#">Промышленные</a></li>
			<li><a href="#">Инфраструктурные</a></li>
		</ul>
	</li>

	<li class="has-subnav">
		<a href="#">Устойчивое развитие</a>

		<ul class="nav__subnav">
			<li><a href="#">Общая информация</a></li>
			<li class="has-subnav">
				<a href="#">Документы по устойчивому развитию</a>

				<ul class="nav__subnav">
					<li><a href="#">Политика</a></li>
					<li><a href="#">Карта стейкхолдеров</a></li>
					<li><a href="#">Отчеты об устойчивом развитии</a></li>
				</ul>
			</li>
			<li><a href="#">Взаимодействие с заинтересованными сторонами</a></li>
		</ul>
	</li>
</ul>
--}}
