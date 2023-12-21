@push('js')
    <script src="/site/js/auth_cert/jquery.js"></script>
    <script src="/site/js/auth_cert/jquery.blockUI.js"></script>
    <script src="/site/js/auth_cert/ncalayer.js"></script>
    <script src="/site/js/auth_cert/process-ncalayer-calls.js"></script>
@endpush

{{--@section('form')--}}
@if ($errors->any())
    <div class="alert alert--danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('error'))
    <div class="alert alert--danger">
        {{ session('error') }}
    </div>
@endif

<form class="form-auth form-panel" action="{{ route('consent.data') }}" method="post">
    {!! csrf_field() !!}
    <div style="text-align: center">
        <h2>Чтобы использовать личный кабинет вам нужно согласиться на сбор и обработку данных</h2>
        <br>
        <br>
    </div>
    @include('site.registrations.form-signature')

    <div class="form-group">
        <input type="text" name="cmsConsent" hidden id="cmsConsent" value="">

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
    </div>

    <div class="form-auth__actions">
        <button class="btn btn--secondary" type="submit">Отправить</button>
    </div>
</form>


{{--@endsection--}}
