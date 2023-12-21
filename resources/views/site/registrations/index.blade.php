@extends('site.registrations.base')

@push('js')
    <script type="text/javascript" src="/site/js/auth_cert/jquery.blockUI.js"></script>
    <script type="text/javascript" src="/site/js/auth_cert/ncalayer.js"></script>
    <script type="text/javascript" src="/site/js/auth_cert/process-ncalayer-calls.js"></script>
@endpush

@section('form')

    @if ($errors->any())
        <div class="alert alert--danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-auth form-panel" action="{{ route('registrations.register') }}" method="post">
        {!! csrf_field() !!}

        @include('site.registrations.form-signature')

        <hr class="form-auth__separator">

        <div class="row row--sm">
            <div class="col-12 col-xl-4">
                <div class="form-group">
                    <label class="form-group__label">Номер телефона</label>

                    <div class="form-group__input">
                        <input class="input" type="text" name="mobile" value="" data-input-phone>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="form-group">
                    <label class="form-group__label">E-mail</label>

                    <div class="form-group__input">
                        <input class="input" type="email" name="email">
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="form-group">
                    <label class="form-group__label">Пароль</label>

                    <div class="form-group__input">
                        <input class="input" type="password" name="password" value="">
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="form-group">
                    <label class="form-group__label">Адрес проживания</label>

                    <div class="form-group__input">
                        <input class="input" type="text" name="address">
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="form-group">
                    <label class="form-group__label">Рабочий телефон</label>

                    <div class="form-group__input">
                        <input class="input" type="text" name="work_phone" data-input-phone>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="form-group">
                    <label class="form-group__label">Домашний телефон</label>

                    <div class="form-group__input">
                        <input class="input" type="text" name="home_phone" data-input-phone>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-12">
                <div class="form-group">
                    <div>
                        <input required class="input" type="checkbox" style="width: 3%; height: 15px; display: inline"
                               name="consent_to_data_collection" value="1">
                        <span style="cursor:pointer;color:blue;" id="btnConsentToDataCollection">Согласие на сбор и обработку персональных данных</span>
                        @include('site.cabinet.snippets.consent-to-data-collection')
                    </div>
                    <div>
                        <input required class="input" type="checkbox" style="width: 3%; height: 15px; display: inline"
                               name="privacy_policy" value="1">
                        <span style="cursor:pointer;color:blue;" id="btnPrivacyPolicy">Политика конфиденциальности </span>
                        @include('site.cabinet.snippets.privacy_policy')
                    </div>
                    <div><input required class="input" type="checkbox" style="width: 3%; height: 15px; display: inline"
                                name="terms_of_use" value="1">
                        <span style="cursor:pointer;color:blue;" id="btnTermsOfUse">Пользовательское соглашение</span>
                        @include('site.cabinet.snippets.terms_of_use')
                    </div>
                </div>
                <div class="form-group">
                    <p style="font-size: 10px; text-align: center">Нажимая кнопку "Зарегистрироваться", Вы автоматически
                        соглашаетесь с политикой конфиденциальности и даете свое согласие на обработку персональных
                        данных».</p>
                </div>
                <div class="form-auth__actions">
                    <a
                        class="btn btn--outline-secondary"
                        href="{{ route('registrations.restore') }}"
                    >Забыли пароль?</a>

                    <button class="btn btn--secondary" type="submit">Зарегистрироваться</button>
                </div>
            </div>
        </div>
    </form>

    <div class="formatted">
        <ul>
            <li>Для арендаторов действующих договоров</li>
        </ul>
    </div>

@endsection
