<ul class="{{ $ulClass }}">
    @foreach ($secondarySubmenu as $secondarySubmenuItem)
        @php $isActiveItem = in_array($secondarySubmenuItem['alias'], $activeLevels) ? 'is-active' : ''; @endphp

        <li class="@if (count($secondarySubmenuItem['children'])){{ 'has-subnav' }}@endif">
            @php $name = 'name_' . app()->getLocale(); @endphp

            @if ($secondarySubmenuItem['type'] !== 'link')
                <a class="{{ $isActiveItem }}" href="/{{ app()->getLocale() }}{{ $secondarySubmenuItem['link'] ?? '' }}">
            @else
                <a
                    class="{{ $isActiveItem }}"
                    @if ((substr($secondarySubmenuItem['link'], 0, 7) === 'http://') ||
                        (substr($secondarySubmenuItem['link'], 0, 8) === 'https://'))
                        {{ 'target="_blank"' }} href="{{ $secondarySubmenuItem['link'] }}"
                    @else
                        href="/{{ app()->getLocale() }}{{ $secondarySubmenuItem['link'] ?? '' }}"
                    @endif
                >
            @endif
                    @if ($ulClass === 'second-nav__subnav')
                        {!! icon('icon--arrow', 'icon--arrow-right') !!}
                    @endif
                    <span>
                        {{ (isset($secondarySubmenuItem[$name]) && !is_null($secondarySubmenuItem[$name]))
                            ? $secondarySubmenuItem[$name]
                            : $secondarySubmenuItem['name_ru'] }}
                    </span>
                </a>

            @if (count($secondarySubmenuItem['children']) > 0)
                @include('site.blocks.second-nav.second-nav-list', [
                    'secondarySubmenu' => $secondarySubmenuItem['children'],
                    'ulClass' => 'second-nav__subnav'
                ])
            @endif
        </li>
    @endforeach
</ul>
