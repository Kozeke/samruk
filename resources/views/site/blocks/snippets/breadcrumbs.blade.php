@if (!empty($breadcrumbs))
    <ul class="breadcrumbs" data-aos="fade-right" data-aos-delay="300">
        <li>
            <a class="link" href="/{{ app()->getLocale() }}/">
                {{ __('translations.home') }}
            </a>
            {!! icon('icon--arrow', 'icon--arrow-right') !!}
        </li>

        @foreach($breadcrumbs as $breadcrumb)
            <li>
                <a
                    class="link {{ $loop->last ? 'is-active' : '' }}"
                    href="/{{ app()->getLocale() }}{{ $breadcrumb['link'] }}"
                >{{ str_limit($breadcrumb['name']) }}</a>
                {!! icon('icon--arrow', 'icon--arrow-right') !!}
            </li>
        @endforeach
    </ul>
@endif
