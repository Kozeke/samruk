<!-- The Modal -->
<div id="modalConsentToDataCollection" class="modal">

    <!-- Modal content -->
    <div class="modal-content-for-data-collection">
        <span id="spanConsentToDataCollection" class="close">&times;</span>
        <span style="text-align: center">
        <h1>Вам нужно подписать ЭЦП ключом соглашение на сбор информации</h1>
            <hr class="form-auth__separator">
{{--            <form class="form-auth form-panel"--}}
{{--                  action="{{ route('cabinet.check-profile-relevance')}}" method="post">--}}
{{--            {!! csrf_field() !!}--}}
                <p>Я ФИО соглашаюсь со сбором информации</p>
                <input hidden type="text" value="Я ФИО соглашаюсь со сбором информации">
                <input  class="btn btn--secondary" value="Подписать" onclick="createCAdESFromBase64CallForConsent();" type="button"
       style="width:50%;"/>
{{--            </form>--}}


    </span>
    </div>

</div>
