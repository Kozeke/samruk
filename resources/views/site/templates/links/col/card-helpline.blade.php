@if (count($links) > 0)
	@php $card = $links->first(); @endphp

	<div class="card card--helpline">
		<a class="card__inner" href="{{ $card->link }}"
			@if((substr($card->link, 0, 7) == 'http://') || (substr($card->link, 0, 8) == 'https://')){{ 'target="_blank"' }}@endif>

			@if ($card->class)
				<div class="card__icon">{!! icon($card->class) !!}</div>
			@endif

			<h4 class="card__title">
				<div>{{ $card->title }}</div>

				@if ($card->description)
					<div class="text-brown font-weight-bold mt-1">{{ strip_tags($card->description) }}</div>
				@endif
			</h4>
		</a>
	</div><!-- /.card -->
@endif
