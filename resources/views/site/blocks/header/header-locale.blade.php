<div class="header-locale">
    @foreach ($langs as $lang)
        @if (in_array($lang->key, ['ru', 'kz', 'en']))
            <a
                class="header-locale__link link {{ $lang->key === app()->getLocale() ? 'is-active' : '' }}"
                href="{{ LaravelLocalization::getLocalizedURL($lang->key) }}"
            >{{ $lang->name }}</a>
        @endif
    @endforeach
</div>
