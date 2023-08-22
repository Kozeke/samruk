<div class="posts-files posts-files--compact">
	<h3 class="title-block">{{ $section->name }}</h3>

	@if ($news)
		<ul class="posts-files__list">
			@foreach ($news as $news_item)
				@php $file = $news_item->media('file')->whereLang(LaravelLocalization::getCurrentLocale())->first(); @endphp

				@if (!is_null($file) && file_exists(public_path($file->link)))
					<li class="posts-files__item">
						<div class="posts-files__icon-wrap">
							<i class="posts-files__icon icon icon--{{ strtolower(formatFile($file->link)) }}"></i>
						</div>

						<div class="posts-files__info">
							<div class="posts-files__title font-italic">
								<a class="link-black" href="/file/save/{{ $file->id }}" download>
									{{ str_limit(strip_tags($news_item->short), 120) }}
								</a>
							</div>
						</div>
					</li>
				@endif
			@endforeach
		</ul>

		<a class="posts-files__more btn btn--square btn--text-left w-100" href="{{ $section->path }}">
			{{ trans('translations.visit_section') }}
		</a>
	@endif
</div><!-- /.posts-files -->
