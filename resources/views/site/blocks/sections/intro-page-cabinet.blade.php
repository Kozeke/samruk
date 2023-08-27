<section class="section intro-page" id="intro-page" data-jarallax>
    <img class="jarallax-img lazy" src="" data-src="/site/img/redesign/intro/intro-cabinet.jpg" alt="">

    <div class="intro-page__inner">
        <div class="intro-page__content container-sm">
            <h1 class="intro-page__title" data-aos="fade-right" data-aos-delay="200">
                @if(isset($settingsPage)&&$settingsPage)
                    Сменить пароль
                @else
                {{ __('translations.personal_cabinet') }}
                @endif

            </h1>
        </div>

        <div class="intro-page__breadcrumbs">
            <div class="container-fluid">
                @include('site.cabinet.snippets.breadcrumbs')
            </div>
        </div>
    </div>
</section>
