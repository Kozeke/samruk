
function getActiveTokensCall() {
    blockScreen();
    getActiveTokens("getActiveTokensBack");
}

function getActiveTokensBack(result) {
    unblockScreen();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var listOfTokens = result['responseObject'];
        $('#storageSelect').empty();
        $('#storageSelect').append('<option value="PKCS12">PKCS12</option>');
        for (var i = 0; i < listOfTokens.length; i++) {
            $('#storageSelect').append('<option value="' + listOfTokens[i] + '">' + listOfTokens[i] + '</option>');
        }
    }
}

function getKeyInfoCall() {
    blockScreen();
    var selectedStorage = $('#storageSelect').val();
    getKeyInfo(selectedStorage, "getKeyInfoBack");
}

function getKeyInfoBack(result) {
    unblockScreen();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];

        console.log(res)
        var subjectCn = res['subjectCn'];
        $("#subjectName").val(subjectCn);

        var subjectDn = res['subjectDn'];
        $("#subjectDn").val(subjectDn);

        var subjectDnIIN = subjectDn.indexOf('IIN');

        if (subjectDnIIN !== -1) {
            subjectDnIIN = subjectDn.substr(subjectDnIIN + 3, 12);
        } else {
            subjectDnIIN = 'Не удалось получить ИИН';
        }

        $("#subjectIIN").val(subjectDnIIN);

        var dateNotAfterString = res['certNotAfter'];
        var dateNotAfter = new Date(Number(dateNotAfterString));
        var notAfter = dateNotAfter.toLocaleString();
        // $("#notafter").val(date.toLocaleString());

        var dateNotBeforeString = res['certNotBefore'];
        var dateNotBefore = new Date(Number(dateNotBeforeString));
        var notBefore = dateNotBefore.toLocaleString();
        // $("#notbefore").val(date.toLocaleString());

        $('#cert_date').val(notBefore + ' - ' + notAfter);

        $("#registrationSubmit").removeAttr('disabled');

        $("#email_form").css("display", "block");

        var alias = res['alias'];
        $("#alias").val(alias);

        var keyId = res['keyId'];
        $("#keyId").val(keyId);

        var algorithm = res['algorithm'];
        $("#algorithm").val(algorithm);
        //
        // var issuerCn = res['issuerCn'];
        // $("#issuerCn").val(issuerCn);
        //
        // var issuerDn = res['issuerDn'];
        // $("#issuerDn").val(issuerDn);
        //
        // var serialNumber = res['serialNumber'];
        // $("#serialNumber").val(serialNumber);
        //
        //
        // var authorityKeyIdentifier = res['authorityKeyIdentifier'];
        // $("#authorityKeyIdentifier").val(authorityKeyIdentifier);
        //
        // var pem = res['pem'];
        // $("#pem").val(pem);

    }

}
function createCAdESFromBase64Call() {
    calc.lockInputs();
    var selectedStorage = "PKCS12";
    var flag = true;
    var base64ToSign = calc.getBasePdfValue();

    // console.log(base64ToSign)
    console.log("createCAdESFromBase64Call")
    if (base64ToSign !== null && base64ToSign !== "") {
        $.blockUI();
        createCAdESFromBase64(selectedStorage, "SIGNATURE", base64ToSign, flag, "createCAdESFromBase64Back");
    } else {
        alert("Нет данных для подписи!");
        $.unblockUI();
    }
}

async function createCAdESFromBase64Back(result) {
    $.unblockUI();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        calc.setCMSPDF(res);
        await calc.signDocument();
    }
}

function createCAdESFromBase64CallForConsent() {
    var selectedStorage = "PKCS12";
    var flag = true;
    var str = "Я ФИО соглашаюсь со сбором информации";

    var base64ToSign = btoa(unescape(encodeURIComponent(str)));
    console.log(base64ToSign)
    console.log("createCAdESFromBase64Call")
    if (base64ToSign !== null && base64ToSign !== "") {
        $.blockUI();
        createCAdESFromBase64(selectedStorage, "SIGNATURE", base64ToSign, flag, "createCAdESFromBase64BackForConsent");
    } else {
        alert("Нет данных для подписи!");
        $.unblockUI();
    }
}


async function createCAdESFromBase64BackForConsent(result) {
    $.unblockUI();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        // calc.setCMSPDF(res);
        // await calc.signDocument();
        await signConsentToDataCollection(res)
    }
}

async function signConsentToDataCollection(res) {
    var str = "Я ФИО соглашаюсь со сбором информации";
    var base64ToSign = btoa(unescape(encodeURIComponent(str)));
    await axios({
        url: '/sign-document',
        method: 'POST',
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            cms_consent: "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",
            base_pdf: "0K8g0KTQmNCeINGB0L7Qs9C70LDRiNCw0Y7RgdGMINGB0L4g0YHQsdC+0YDQvtC8INC40L3RhNC+0YDQvNCw0YbQuNC4",
        }
    }).then((response) => {
        console.log("success", response);
        var dateNotAfterString = response.data['certificate_valid_from'];
        var dateNotAfter = new Date(Number(dateNotAfterString));
        var notAfter = dateNotAfter.toLocaleString();
        // $("#notafter").val(date.toLocaleString());

        var dateNotBeforeString = res['certNotBefore'];
        var dateNotBefore = new Date(Number(dateNotBeforeString));
        var notBefore = dateNotBefore.toLocaleString();
        // $("#notbefore").val(date.toLocaleString());
        $('#cert_date').val(notBefore + ' - ' + notAfter);

        var subjectDnIIN = subjectDn.indexOf('IIN');

        if (subjectDnIIN !== -1) {
            subjectDnIIN = subjectDn.substr(subjectDnIIN + 3, 12);
        } else {
            subjectDnIIN = 'Не удалось получить ИИН';
        }

        $("#subjectIIN").val(subjectDnIIN);
        var subjectCn = res['subjectCn'];
        $("#subjectName").val(subjectCn);
        // self.signed = true;
        // self.signerFIO = response.data['fio']
        // console.log(self.signerFIO)
        // self.value_qr = response.data.value_qr
        // console.log(self.value_qr)
    })
}
