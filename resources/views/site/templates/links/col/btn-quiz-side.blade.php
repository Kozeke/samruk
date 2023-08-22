@if (count($links))
	@php $link = $links->first(); @endphp

    @if ($link->link !== '#')
        <a
            class="btn btn--primary btn-side"
            href="{{ $link->link }}"
            @if ((substr($link->link, 0, 7) == 'http://') || (substr($link->link, 0, 8) == 'https://'))
                target="_blank"
            @endif
        >{{ __('translations.takeTheSurvey') }}</a>
    @endif
@endif
