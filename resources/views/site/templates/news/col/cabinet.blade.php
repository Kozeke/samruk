@if ($news)
    <div class="posts posts--hero">
        <div class="posts__list row">
            @foreach ($news as $news_item)
                <div class="posts__item col-md-6">
                    <div class="posts__info">
                        <h4 class="posts__title">
                            {{ str_limit(strip_tags($news_item->title), 100) }}
                        </h4>

                        <div class="d-flex justify-content-between">
                            <div>
                                <time class="posts__date">{{ date('d.m.Y', strtotime($news_item->published_at)) }}</time>
                            </div>

                            <div>
                                <a href="{{ $news_item->url }}">Читать далее</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div><!-- /.posts -->
@endif
