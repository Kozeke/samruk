<header class="header">
    <div class="header__inner container-fluid">
        <div class="header__top">
            @include('site.blocks.header.header-login')
        </div>

        <div class="header__left">
            @include('site.blocks.header.header-logo')
        </div>

        <div class="header__right">
            <div class="header__search">
                @include('site.blocks.header.header-search')
            </div>

            <div class="header__socials">
                {!! getLinks('col-socials-list', 'socials') !!}
            </div>

            <div class="header__links">
                <div class="header-links">
                    @include('site.blocks.header.header-link-contacts')
                </div>
            </div>

            <div class="header__locale">
                @include('site.blocks.header.header-locale')
            </div>

            <div class="header__nav">
                @include('site.blocks.nav.nav')
            </div>

            <button class="header-toggle js-header-toggle">
                <span class="header-toggle__inner"></span>
            </button>
        </div>
    </div>

    <div class="header-mob js-header-mob">
        <div class="header-mob__inner">
            <div class="header-mob__login">
                @include('site.blocks.header.header-login')
            </div>

            <div class="header-mob__locale">
                @include('site.blocks.header.header-locale')
            </div>

            <div class="header-mob__socials">
                {!! getLinks('col-socials-list', 'socials') !!}
            </div>

            <div class="header-mob__search">
                @include('site.blocks.header.header-search')
            </div>

            <div class="header-mob__nav">
                @include('site.blocks.nav.nav')
            </div>
        </div>
    </div>
</header>
