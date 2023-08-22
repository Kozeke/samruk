@if (count($links) > 0)
	<div class="intro-refs intro-refs--page">
		<div class="container">
			<div class="row">
				@foreach ($links as $link)
					<div class="intro-refs__item col-sm-6 col-lg-3">
						<a class="intro-refs__link intro-refs__link--column" href="{{ $link->link }}"
							 @if((substr($link->link, 0, 7) == 'http://') || (substr($link->link, 0, 8) == 'https://')){{ 'target="_blank"' }}@endif>
							<div class="intro-refs__icon intro-refs__icon--small">{!! icon($link->class) !!}</div>
							<div class="intro-refs__title">{{ $link->title }}</div>
						</a>
					</div>
				@endforeach
			</div><!-- /.row -->
		</div><!-- /.container -->
	</div><!-- /.intro-refs -->
@endif

{{--
<div class="intro-refs intro-refs--page">
	<div class="container">
		<div class="row">
			<div class="intro-refs__item col-md-3">
				<a class="intro-refs__link intro-refs__link--column" href="https://dom.fnsk.kz/" target="_blank">
					<div class="intro-refs__icon intro-refs__icon--small">{!! icon('icon--desktop') !!}</div>
					<div class="intro-refs__title">Подать заявку на жилье</div>
				</a>
			</div>

			<div class="intro-refs__item col-md-3">
				<a class="intro-refs__link intro-refs__link--column" href="http://fnsk.ir.kz/ru/page/cherez-internet">
					<div class="intro-refs__icon intro-refs__icon--small">{!! icon('icon--home') !!}</div>
					<div class="intro-refs__title">Как купить квартиру через интернет</div>
				</a>
			</div>

			<div class="intro-refs__item col-md-3">
				<a class="intro-refs__link intro-refs__link--column" href="http://fnsk.ir.kz/ru/page/instrukciya-po-oplate">
					<div class="intro-refs__icon intro-refs__icon--small">{!! icon('icon--card') !!}</div>
					<div class="intro-refs__title">Как оплатить арендные платежи</div>
				</a>
			</div>

			<div class="intro-refs__item col-md-3">
				<a class="intro-refs__link intro-refs__link--column" href="http://fnsk.ir.kz/ru/news/kalkulyator">
					<div class="intro-refs__icon intro-refs__icon--small">{!! icon('icon--calculator') !!}</div>
					<div class="intro-refs__title">Калькулятор расчета арендного платежа</div>
				</a>
			</div>
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /.intro-refs -->
--}}
