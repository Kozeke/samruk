
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
async function createCAdESFromBase64Call() {
    calc.lockInputs();
    var selectedStorage = "PKCS12";
    var flag = true;
    calc.printPdf(true);
    var base64ToSign = calc.getBasePdfValue();

    console.log(base64ToSign)
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
            signature_cms: res,
            document_base64: base64ToSign,
        }
    }).then((response) => {
        console.log("success", response);
        var dateNotAfterString = response.data.certificate_valid_from;
        var dateNotAfter = new Date(Number(dateNotAfterString));
        var notAfter = dateNotAfter.toLocaleString();
        // $("#notafter").val(date.toLocaleString());

        var dateNotBeforeString = response.data.certificate_valid_to;
        var dateNotBefore = new Date(Number(dateNotBeforeString));
        var notBefore = dateNotBefore.toLocaleString();
        // $("#notbefore").val(date.toLocaleString());
        $('#cert_date').val(dateNotAfterString + ' - ' + dateNotBeforeString);

        $("#subjectIIN").val(response.data.iin);
        $("#subjectName").val(response.data.fio);
        $("#cmsConsent").val(res);
        // self.signed = true;
        // self.signerFIO = response.data['fio']
        // console.log(self.signerFIO)
        // self.value_qr = response.data.value_qr
        // console.log(self.value_qr)
    })
}
