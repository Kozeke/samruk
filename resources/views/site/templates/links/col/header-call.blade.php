@if (count($links) > 0)
	@php $link = $links->first(); @endphp

	<div class="header-call">
		<div class="header-call__icon">{!! icon('icon--call') !!}</div>

		<div class="header-call__desc">
			<a class="header-call__number link link-inherit"
				 href="{{ $link->link }}">{{ $link->title }}</a>

			@if ($link->description)
				<div class="header-call__text">{{ strip_tags($link->description) }}</div>
			@endif
		</div>
	</div><!-- /.header-call -->
@endif

{{--
<div class="header-call">
	<div class="header-call__icon">{!! icon('icon--call') !!}</div>
	<div class="header-call__desc">
		<a class="header-call__number link link--inherit" href="tel:88008000111">
			8-800-8000-111
		</a>
		<div class="header-call__text">Call Center компании</div>
	</div>
</div>
--}}
