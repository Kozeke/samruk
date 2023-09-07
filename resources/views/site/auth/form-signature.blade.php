<div class="form-auth__signature">
    <div class="form-auth__signature-left" id="signDoc">
        <input type="hidden" name="PKCS12" value="PKCS12" id="storageSelect">
        <a class="form-auth__signature-choose" href="javascript:;" onclick="createCAdESFromBase64CallForConsent();">
            {!! icon('icon--key') !!}
            <span>Выбрать ЭЦП</span>
        </a>
    </div>

    <div class="form-auth__signature-right">
        <div class="form-auth__signature-inputs">
            <label class="form-auth__signature-input">
                <input
                    class="input"
                    type="text"
                    placeholder="ФИО*"
                    name="subjectName"
                    value=""
                    id="subjectName"
                    readonly
                >
            </label>

            <label class="form-auth__signature-input">
                <input
                    class="input"
                    type="text"
                    placeholder="ИИН*"
                    name="subjectIIN"
                    value=""
                    id="subjectIIN"
                    readonly
                >
            </label>

            <label class="form-auth__signature-input">
                <input
                    class="input"
                    type="text"
                    placeholder="Срок действия*"
                    name="cert_date"
                    value=""
                    id="cert_date"
                    readonly
                >
            </label>
        </div>

        <input type="hidden" name="algorithm" value="" id="algorithm"/>
        <div class="form-auth__signature-hint">
            {{--* Для заполнения этих полей необходимо выбрать ключ ЭЦП--}}
            * Выберите ЭЦП ключ чтобы подписать согласие на сбор и обработку персональных данных
        </div>
    </div>
</div>
