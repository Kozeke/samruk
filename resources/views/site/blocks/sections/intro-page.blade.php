@php
    $sectionMainParent = isset($section) ? getMainParent($section) : null;

    if (isset($introPageBgUrl)) {
        $introPageBg = $introPageBgUrl;
    } elseif (isset($section) && $sectionMainParent->alias === 'arendatoram') {
        $introPageBg = '/site/img/redesign/intro/intro-tenants.jpg';
    } elseif (isset($section) && $sectionMainParent->alias === 'investoram') {
        $introPageBg = '/site/img/redesign/intro/intro-invest.jpg';
    } elseif (isset($section) && $sectionMainParent->alias === 'zakupki') {
        $introPageBg = '/site/img/redesign/intro/intro-purchases.jpg';
    } else {
        $introPageBg = '/site/img/redesign/intro/intro-default.jpg';
    }
@endphp

<section class="section intro-page" id="intro-page" data-jarallax>
    <img class="jarallax-img lazy" src="" data-src="{{ $introPageBg }}" alt="">

    <div class="intro-page__inner">
        <div class="intro-page__content container-sm">
            <h1 class="intro-page__title" data-aos="fade-right" data-aos-delay="200">
                @if (isset($introPageTitle) && $introPageTitle)
                    {{ $introPageTitle }}
                @elseif (isset($section) && $section)
                    {{ $section->name }}
                @endif
            </h1>
        </div>

        <div class="intro-page__breadcrumbs">
            <div class="container-fluid">
                @if (isset($isCabinet))
                    @include('site.cabinet.snippets.breadcrumbs')
                @else
                    @include('site.blocks.snippets.breadcrumbs')
                @endif
            </div>
        </div>
    </div>
</section>
