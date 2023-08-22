<nav class="nav{{ isset($navClasses) ? ' ' . $navClasses : '' }}">
    @include('site.blocks.nav.nav-list', [
        'structures' => $structures,
        'ulClass' => 'nav__list',
        'activeLevels' => getUpperLevels(request()->alias)
    ])
</nav>
