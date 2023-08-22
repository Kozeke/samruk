@if ($videos->count() > 0)
    <div class="post-videos">
        @foreach ($videos as $video)
            @php $title = 'title_' . LaravelLocalization::getCurrentLocale(); @endphp

            <div class="post-videos__item ratio">
                <iframe src="https://www.youtube.com/embed/{{ getCodeVideo($video->link) }}?rel=0" frameborder="0"
                        allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
            </div>
        @endforeach
    </div>
@endif
