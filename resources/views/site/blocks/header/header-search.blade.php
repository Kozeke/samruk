<form class="header-search" action="{{ route('site.search') }}">
    <input
        class="header-search__input"
        autocomplete="off"
        name="query"
        type="text"
        placeholder="{{ __('translations.search.site') }}"
    >
    <button class="header-search__submit">{!! icon('icon--magnifier') !!}</button>
</form>
