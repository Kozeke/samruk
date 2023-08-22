<section class="section section--bg-gray posts" id="posts">
    <div class="container">
        <h2
            class="title-section"
            data-aos="fade-right"
            data-aos-delay="200"
        >{{ __('translations.companyNews') }}</h2>

        <div class="posts-list">
            @php $aosDelay = 0; @endphp

            @foreach ($news as $nws)
                @php $aosDelay += 100; @endphp

                @if ($loop->iteration <= 3)
                    @include('site.blocks.snippets.post-card', ['record' => $nws, 'aosDelay' => $aosDelay])
                @endif
            @endforeach
        </div>

        <div class="posts-more">
            <a
                class="btn btn--secondary"
                href="{{ $section->path }}"
            >{{ __('translations.allNews') }}</a>
        </div>
    </div>
</section>

