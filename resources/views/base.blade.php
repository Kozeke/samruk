@include('site.blocks.base.header')
    @include('site.blocks.preloader')
    @include('site.blocks.svg-sprite')

    <div class="wrap">
        @include('site.blocks.header.header')

        <main class="main">@yield('main')        </main>
					    	
        @include('site.blocks.footer.footer')
    </div>

    @include('site.blocks.snippets.btn-side-group')
    @stack('modal')

@include('site.blocks.base.footer')
