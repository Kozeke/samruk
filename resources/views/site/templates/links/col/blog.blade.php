@if (count($links) > 0)
	@php $blog = $links->first(); @endphp

	<h3 class="title-block title-block--border-none d-none d-xl-block">
		{{ $section->name }}
	</h3>

	<div class="blog-card">
		<div class="blog-card__content">
			<div class="blog-card__desc">{!! strip_tags($blog->description, '<br>') !!}</div>

			<h4 class="blog-card__title">{{ $blog->title }}</h4>
		</div>

		<a class="blog-card__more btn btn--square btn--text-left w-100"
			 href="{{ $blog->link }}"
			 @if((substr($blog->link, 0, 7) == 'http://') || (substr($blog->link, 0, 8) == 'https://')){{ 'target="_blank"' }}@endif>
			{{ trans('translations.visit_blog') }}
		</a>
	</div><!-- /.blog-card -->
@endif
