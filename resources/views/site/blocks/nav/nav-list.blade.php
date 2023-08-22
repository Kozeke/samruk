<ul class="{{ $ulClass }}">
    @foreach ($structures as $structure)
        @php $isActiveItem = in_array($structure['alias'], $activeLevels) ? ' is-active' : ''; @endphp
        @php $isSubnavShow = in_array($structure['alias'], $activeLevels); @endphp

        <li class="{{ $ulClass === 'nav__list' ? 'nav__item' : '' }}{{ count($structure['children']) ? ' has-subnav' : '' }}{{ $isActiveItem }}">
            @php $name = 'name_' . app()->getLocale(); @endphp

            @if ($ulClass === 'nav__list')
                <a
                    class="nav__link{{ count($structure['children']) ? ' has-subnav' : '' }}{{ $isActiveItem }}"
                    @if ($structure['type'] != 'link')
                        href="/{{ app()->getLocale() }}{{ $structure['link'] ?? '' }}"
                    @else
                        @if ((substr($structure['link'], 0, 7) == 'http://') || (substr($structure['link'], 0, 8) == 'https://'))
                            href="{{ $structure['link'] }}" {{ 'target="_blank"' }}
                        @else
                            @if (str_starts_with($structure['link'], '#'))
                                href="{{ $indexPage ? '' : '/' . app()->getLocale() . '/' }}{{ $structure['link'] ?? '' }}" data-link-anchor
                            @else
                                href="/{{ app()->getLocale() }}{{ $structure['link'] ?? '' }}"
                            @endif
                        @endif
                    @endif
                >{{ (isset($structure[$name]) && !is_null($structure[$name])) ? $structure[$name] : $structure['name_ru'] }}</a>
            @else
                <a
                    class="{{ count($structure['children']) ? ' has-subnav' : '' }}{{ $isActiveItem }}"
                    @if ($structure['type'] != 'link')
                        href="/{{ app()->getLocale() }}{{ $structure['link'] ?? '' }}"
                    @else
                        @if ((substr($structure['link'], 0, 7) == 'http://') || (substr($structure['link'], 0, 8) == 'https://'))
                            href="{{ $structure['link'] }}" {{ 'target="_blank"' }}
                        @else
                            href="/{{ app()->getLocale() }}{{ $structure['link'] ?? '' }}"
                        @endif
                    @endif
                >{{ (isset($structure[$name]) && !is_null($structure[$name])) ? $structure[$name] : $structure['name_ru'] }}</a>
            @endif

            @if (count($structure['children']))
                @include('site.blocks.nav.nav-list', [
                    'structures' => $structure['children'],
                    'ulClass' => $ulClass === 'nav__list' ? 'nav-subnav' : '',
                    'activeLevels' => $activeLevels
                ])
            @endif
        </li>
    @endforeach

    @if ($ulClass === 'nav__list')
        @include('site.blocks.header.header-link-contacts', ['isNav' => true])
    @endif
</ul>
