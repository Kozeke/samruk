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
