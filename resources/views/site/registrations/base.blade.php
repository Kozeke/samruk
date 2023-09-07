@extends('site.templates.pages')

@push('vendor-js')
    <script src="/site/js/auth_cert/jquery.js"></script>
    <script src="/site/js/auth_cert/jquery-browser.js"></script>
@endpush

@section('main')

    @include('site.blocks.sections.intro-page', [
        'introPageTitle' => __('translations.loginToCabinet'),
        'introPageBgUrl' => '/site/img/redesign/intro/intro-blog-2.jpg'
    ])

    <section class="section cabinet">
        <div class="cabinet__inner container" data-aos="fade-up" data-aos-delay="200">
            <div class="cabinet__main">
                <h2 class="title-page">
                    @if (Route::is('auth.ecp'))
                        {{ __('translations.loginWithEDS') }}
                    @elseif(Route::is('auth.index'))
                        {{ __('translations.loginWithPassword') }}
                    @elseif(Route::is('registrations.*'))
                        {{ __('translations.registration') }}
                    @endif
                </h2>

                @yield('form')
            </div>

            <aside class="cabinet__aside">
                <div class="cabinet__aside-item second-nav">
                    <ul class="second-nav__list">
                        <li>
                            <a class="{{ Route::is('auth.ecp') ? 'is-active' : ''}}"
                               href="{{ route('auth.ecp') }}">{{ __('translations.loginWithEDS') }}</a>
                        </li>
                        <li>
                            <a class="{{ Route::is('auth.index') ? 'is-active' : ''}}"
                               href="{{ route('auth.index') }}">{{ __('translations.loginWithPassword') }}</a>
                        </li>
{{--                        <li>--}}
{{--                            <a class="{{ Route::is('sms.*') ? 'is-active' : ''}}"--}}
{{--                               href="{{ route('sms.auth') }}">{{ __('translations.loginWithSMS') }}</a>--}}
{{--                        </li>--}}
                        <li>
                            <a class="{{ Route::is('registrations.*') ? 'is-active' : ''}}"
                               href="{{ route('registrations.index') }}">{{ __('translations.registration') }}</a>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </section>

@endsection
