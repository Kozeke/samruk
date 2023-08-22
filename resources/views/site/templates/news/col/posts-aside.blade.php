<div class="sidebar-block">
	<div class="sidebar-block__head">
		<h4 class="sidebar-block__title">{{ trans('translations.last_news') }}</h4>
	</div>

	@if ($news)
		<div class="posts posts--aside">
			<div class="posts__list">
				@foreach ($news as $news_item)
					@if ($loop->iteration <= 3)
						<div class="posts__item">
							<div class="posts__info">
								<time class="posts__date" datetime="{{ date('Y-m-d', strtotime($news_item->published_at)) }}">
									{{ date('d.m.Y', strtotime($news_item->published_at)) }}
								</time>

								<h3 class="posts__title">
									<a href="{{ $news_item->url }}">{{ str_limit(strip_tags($news_item->title), 135) }}</a>
								</h3>
							</div>
						</div>
					@endif
				@endforeach
			</div>
		</div><!-- /.posts -->
	@endif
</div>
