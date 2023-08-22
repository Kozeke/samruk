@if (!isset($showAside))
    @php $showAside = isset($section) && $section->submenu; @endphp
@endif

<section class="section page" id="page">
    <div class="page__inner container" data-aos="fade-up" data-aos-delay="200">
        <div class="page__main {{ $showAside ? '' : 'w-100'  }}">{{ $slot }}</div>

        @if ($showAside)
            @include('site.blocks.aside')
        @endif
    </div>
</section>
