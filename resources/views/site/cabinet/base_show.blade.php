@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page-cabinet')
@endsection

@section('content')

    <section class="section cabinet">
        <div class="cabinet__inner container" data-aos="fade-up" data-aos-delay="200">
            @include('site.cabinet.snippets.header')

            <div class="cabinet__main">
                @yield('show_cabinet')
                @include('site.cabinet.snippets.home-page-btn')
            </div>

            <aside class="cabinet__aside">
                @include('site.cabinet.snippets.contract-aside')
                @include('site.cabinet.snippets.nav')
                @include('site.cabinet.snippets.contract-payment')
            </aside>
        </div>
    </section>

@endsection

