@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page-cabinet')
@endsection

@section('content')
<section class="section cabinet">
    <div class="cabinet__inner container" data-aos="fade-up" data-aos-delay="200">
        @include('site.cabinet.snippets.header')

        <div class="cabinet__main">
            <h2 class="title-page">Сменить пароль</h2>

            @if ($success === true)
                <div class="alert alert--success">Пароль успешно сменен</div>
            @endif

            <form class="form-panel" action="{{ route('cabinet.save_pass') }}" method="post">
                {!! csrf_field(); !!}

                <div class="row row--sm">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <div class="form-group__input">
                                <input
                                    class="input"
                                    type="password"
                                    name="password"
                                    value=""
                                    placeholder="Введите новый пароль"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <div class="form-group__input">
                                <input
                                    class="input"
                                    type="password"
                                    name="confirm"
                                    value=""
                                    placeholder="Подтвердите новый пароль"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="form-panel__actions">
                            <button class="btn btn--secondary" type="submit">Сменить</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <aside class="cabinet__aside">
        </aside>
    </div>
</section>
@endsection
