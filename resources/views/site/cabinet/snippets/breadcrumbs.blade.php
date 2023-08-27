<ul class="breadcrumbs" data-aos="fade-right" data-aos-delay="300">
    <li>
        <a class="link" href="/{{ app()->getLocale() }}/">
            {{ __('translations.home') }}
        </a>
        {!! icon('icon--arrow', 'icon--arrow-right') !!}
    </li>

    @if (isset($id))
        <li>
            <a
                class="link"
                href="/{{ app()->getLocale() }}/cabinet/"
            >{{ __('translations.personal_cabinet') }}</a>
            {!! icon('icon--arrow', 'icon--arrow-right') !!}
        </li>

        <li>
            <a
                class="link"
                href="/{{ app()->getLocale() }}/cabinet/{{ $id }}"
            >Договор №{{ $id }}</a>
        </li>
        @elseif(isset($settingsPage))
        <li>
            <a
                class="link"
                href="/{{ app()->getLocale() }}/cabinet/"
            >{{ __('translations.personal_cabinet') }}</a>
            {!! icon('icon--arrow', 'icon--arrow-right') !!}
        </li>
        <li>
            <a
                class="link"
                href="/{{ app()->getLocale() }}/cabinet/settings"
            >{{ __('translations.settings') }}</a>
        </li>
    @else
        <li>
            <a
                class="link"
                href="/{{ app()->getLocale() }}/cabinet/"
            >{{ __('translations.personal_cabinet') }}</a>
        </li>
    @endif
</ul>
