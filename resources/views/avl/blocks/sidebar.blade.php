<div class="sidebar">
  @can('update', new \App\Models\Sections)
    <nav class="sidebar-nav">
      <div class="custom__menu">
        @include('avl.blocks.sections', ['structures' => $structures, 'level' => 0,])
      </div>
    </nav>
    {{-- <button class="sidebar-minimizer brand-minimizer" type="button"></button> --}}
  @endcan
</div>
