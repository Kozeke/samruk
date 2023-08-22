@php $secondarySubmenu = getParents($section); @endphp

@if ($secondarySubmenu)
    <div class="aside__item aside__item--nav second-nav">
        @include('site.blocks.second-nav.second-nav-list', [
            'secondarySubmenu' => $secondarySubmenu,
            'ulClass' => 'second-nav__list',
            'activeLevels' => getUpperLevels(request()->alias)
        ])
    </div>
@endif
