
@include('avl.blocks.head')

    @include('avl.blocks.header')

    <div class="app-body">

      @include('avl.blocks.sidebar')

        <!-- Main content -->
        <main class="main">
            @include('avl.blocks.main')
        </main>
        <!-- END Main content -->

        @include('avl.blocks.aside-menu')

    </div>

@include('avl.blocks.footer')
