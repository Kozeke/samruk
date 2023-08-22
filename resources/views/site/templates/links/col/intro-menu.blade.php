@if (count($links) > 0)
	<div class="intro-menu">
		<div class="intro-menu__row d-flex">
			@foreach ($links as $link)
				<div class="intro-menu__item intro-menu__item--{{ $loop->index + 1 }}" style="background-image: url('/{{ $link->photo }}')">
					<div class="intro-menu__inner d-flex">
						@if ($link->class)
							<div class="intro-menu__icon">{!! icon($link->class) !!}</div>
						@endif

						<div class="intro-menu__info{{ (!$link->class) ? ' w-100' : '' }}">
							<h2 class="intro-menu__title{{ $loop->first ? ' animate animate--flash' : '' }}">
                                {{ $link->title }}
                            </h2>
							<div class="intro-menu__desc">{!! $link->description !!}</div>
						</div>

						{{-- <div class="intro-menu__more">
							<a class="intro-menu__more-btn btn"
								 href="http://fnsk.ir.kz/ru/page/cherez-internet" tabindex="-1">
								<span>Смотреть раздел</span>
								{!! icon('icon--barb-right') !!}
							</a>
						</div> --}}
					</div>
				</div>
			@endforeach
		</div>
	</div><!-- /.intro-menu -->
@endif

{{--
<div class="intro-menu">
	<div class="intro-menu__row d-flex">
		<div class="intro-menu__item intro-menu__item--1" style="background-image: url('/site/img/intro/menu/implement-bg.png')">
			<div class="intro-menu__inner d-flex">
				<div class="intro-menu__icon">{!! icon('icon--implement') !!}</div>

				<div class="intro-menu__info">
					<h2 class="intro-menu__title">Реализация недвижимости</h2>

					<div class="intro-menu__desc">
						<p>- Аренда с выкупом</p>
						<p>- Прямая продажа</p>
						<p>- Реализация коммерческих помещений</p>
					</div>
				</div>

				<div class="intro-menu__more">
					<a class="intro-menu__more-btn btn"
						 href="http://fnsk.ir.kz/ru/page/cherez-internet" tabindex="-1">
						<span>Смотреть раздел</span>
						{!! icon('icon--barb-right') !!}
					</a>
				</div>
			</div>
		</div>

		<div class="intro-menu__item intro-menu__item--2" style="background-image: url('/site/img/intro/menu/our-projects-bg.png')">
			<div class="intro-menu__inner d-flex">
				<div class="intro-menu__icon">{!! icon('icon--building') !!}</div>

				<div class="intro-menu__info">
					<h2 class="intro-menu__title">Наши проекты</h2>

					<div class="intro-menu__desc">
						<p>- Социальные</p>
						<p>- Промышленные</p>
						<p>- Жилые объекты</p>
					</div>

				</div>

				<div class="intro-menu__more">
					<a class="intro-menu__more-btn btn"
						 href="http://fnsk.ir.kz/ru/page/proekty-kompanii" tabindex="-1">
						<span>Смотреть раздел</span>
						{!! icon('icon--barb-right') !!}
					</a>
				</div>
			</div>
		</div>

		<div class="intro-menu__item intro-menu__item--3" style="background-image: url('/site/img/intro/menu/invest-bg.png')">
			<div class="intro-menu__inner d-flex">
				<div class="intro-menu__icon">{!! icon('icon--invest') !!}</div>

				<div class="intro-menu__info">
					<h2 class="intro-menu__title">Инвестиционная деятельность</h2>

					<div class="intro-menu__desc">
						<p>- Девелопмент недвижимости</p>
						<p>- Управление проектами</p>
						<p>- Инвестиционно-стратегические направления</p>
					</div>
				</div>

				<div class="intro-menu__more">
						<a class="intro-menu__more-btn btn"
							 href="http://fnsk.ir.kz/ru/page/investicionnaya-deyatelnost" tabindex="-1">
							<span>Смотреть раздел</span>
							{!! icon('icon--barb-right') !!}
						</a>
					</div>
			</div>
		</div>
	</div>
</div><!-- /.intro-menu -->
--}}
