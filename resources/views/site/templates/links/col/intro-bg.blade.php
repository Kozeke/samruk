@if (count($links) > 0)
	<div class="intro-bg js-intro-bg">
		@foreach ($links as $link)
			<div class="intro-bg__item js-intro-bg-item{{ $loop->first ? ' is-active' : '' }}"
					 style="background-image: url('/{{ $link->photo }}');"></div>
		@endforeach
	</div><!-- /.intro-bg -->
@endif

{{--
<div class="intro-bg js-intro-bg">
	<div class="intro-bg__item js-intro-bg-item is-active" style="background-image: url('/site/img/intro/bg/10.jpg?v=1.2');"></div>
	<div class="intro-bg__item js-intro-bg-item" style="background-image: url('/site/img/intro/bg/9.jpg?v=1.2');"></div>
	<div class="intro-bg__item js-intro-bg-item" style="background-image: url('/site/img/intro/bg/8.jpg?v=1.2');"></div>
	<div class="intro-bg__item js-intro-bg-item" style="background-image: url('/site/img/intro/bg/7.jpg?v=1.2');"></div>
	<div class="intro-bg__item js-intro-bg-item" style="background-image: url('/site/img/intro/bg/6.jpg?v=1.2');"></div>
	<div class="intro-bg__item js-intro-bg-item" style="background-image: url('/site/img/intro/bg/5.jpg?v=1.2');"></div>
	<div class="intro-bg__item js-intro-bg-item" style="background-image: url('/site/img/intro/bg/4.jpg?v=1.2');"></div>
	<div class="intro-bg__item js-intro-bg-item" style="background-image: url('/site/img/intro/bg/3.jpg?v=1.2');"></div>
	<div class="intro-bg__item js-intro-bg-item" style="background-image: url('/site/img/intro/bg/2.jpg?v=1.2');"></div>
	<div class="intro-bg__item js-intro-bg-item" style="background-image: url('/site/img/intro/bg/1.jpg?v=1.2');"></div>
</div><!-- /.intro-bg -->
--}}
