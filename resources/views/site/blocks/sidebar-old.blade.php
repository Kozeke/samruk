<aside class="sidebar">
	<div class="sidebar__inner row">
		@php $secondarySubmenu = getParents($section); @endphp

		@if ($secondarySubmenu)
			<div class="col-12">
				<div class="sidebar-block second-nav">
					@include('site.blocks.second-nav-list', ['secondarySubmenu' => $secondarySubmenu, 'ulClass' => 'second-nav__list'])
				</div>
			</div>

		@endif

		{{-- @if ($structures)
			<div class="col-12">
				<div class="sidebar-block second-nav">
					@include('site.blocks.second-nav-list', ['structures' => $structures, 'ulClass' => 'second-nav__list'])
				</div>
			</div>
		@endif --}}

		<div class="col-12">
			{!! getNews('news', 'posts-aside') !!}
		</div>

		<div class="col-12">
			<div class="sidebar-block">
				{!! getLinks('col-blog', 'blog-aside') !!}
			</div>
		</div>

		<div class="col-12">
			<div class="sidebar-block">
				{!! getLinks('col-faq', 'card-large') !!}
			</div>
		</div>

        <div class="col-12">
            {!! getLinks('col-banner', 'banner-aside') !!}
        </div>
	</div>
</aside>
