@if (isset($isNav))
    <li class="nav__item nav__item--mob">
        <a
            class="nav__link"
            href="/{{ app()->getLocale() }}/page/kontakty"
        >{{ __('translations.contacts') }}</a>
    </li>
@else
    <a
        class="header-links__item link"
        href="/{{ app()->getLocale() }}/page/kontakty"
    >{{ __('translations.contacts') }}</a>
@endif
