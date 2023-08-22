
@push('js')
    <script src="/site/js/auth_cert/jquery.js"></script>
    <script src="/site/js/auth_cert/jquery.blockUI.js"></script>
    <script src="/site/js/auth_cert/ncalayer.js"></script>
    <script src="/site/js/auth_cert/process-ncalayer-calls.js"></script>
@endpush

{{--@section('form')--}}
    <h3>Чтобы использовать личный кабинет вам нужно согласиться на сбор и обработку данных</h3>
    @if (session('error'))
        <div class="alert alert--danger">
            {{ session('error') }}
        </div>
    @endif

    <form class="form-auth form-panel" action="{{ route('consent.data') }}" method="post">
        {!! csrf_field() !!}

        @include('site.auth.form-signature')

        <div class="form-group">
            <input class="input" type="checkbox" style="width: 2%; height: 1%; display: inline" name="consent_to_data_collection" value="1" required>
            <label>Согласие на сбор и обработку данных</label>
        </div>

        <div class="form-auth__actions">
            <button class="btn btn--secondary" type="submit">Отправить</button>
        </div>
    </form>



{{--@endsection--}}
