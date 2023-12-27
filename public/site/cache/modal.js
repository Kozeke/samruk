// Get the modal
var modalPrivacyPolicy = document.getElementById("modalPrivacyPolicy");
var modalConsentToDataCollection = document.getElementById("modalConsentToDataCollection");
var modalTermsOfUse = document.getElementById("modalTermsOfUse");
var checkProfileNeed = document.getElementById("checkProfileNeed");


// Get the button that opens the modal
var btnConsentToDataCollection = document.getElementById("btnConsentToDataCollection");
var btnPrivacyPolicy = document.getElementById("btnPrivacyPolicy");
var btnTermsOfUse = document.getElementById("btnTermsOfUse");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var spanConsentToDataCollection = document.getElementById("spanConsentToDataCollection");
var spanPrivacyPolicy = document.getElementById("spanPrivacyPolicy");
var spanTermsOfUse = document.getElementById("spanTermsOfUse");

// When the user clicks on the button, open the modal
if (checkProfileNeed) {
    checkProfileNeed.style.display = "block";
    checkProfileNeed.scrollIntoView();
}
if (modalConsentToDataCollection) {
    btnConsentToDataCollection.onclick = function () {
        if (modalConsentToDataCollection) {
            modalConsentToDataCollection.style.display = "block";
            modalConsentToDataCollection.scrollIntoView();
        }
    }
}
if (modalPrivacyPolicy) {
    btnPrivacyPolicy.onclick = function () {
        if (modalPrivacyPolicy) {
            modalPrivacyPolicy.style.display = "block";
            modalPrivacyPolicy.scrollIntoView();
        }
    }
}
if (modalTermsOfUse) {
    btnTermsOfUse.onclick = function () {
        if (modalTermsOfUse) {
            modalTermsOfUse.style.display = "block";
            modalTermsOfUse.scrollIntoView();
        }
    }
}
// When the user clicks on <span> (x), close the modal
if (spanPrivacyPolicy) {
    spanPrivacyPolicy.onclick = function () {
        modalPrivacyPolicy.style.display = "none";
    }
}

if (spanConsentToDataCollection) {
    spanConsentToDataCollection.onclick = function () {
        modalConsentToDataCollection.style.display = "none";
    }
}

if (spanTermsOfUse) {
    spanTermsOfUse.onclick = function () {
        modalTermsOfUse.style.display = "none";
    }
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modalConsentToDataCollection) {
        modalConsentToDataCollection.style.display = "none";
    }
    if (event.target == modalPrivacyPolicy) {
        modalPrivacyPolicy.style.display = "none";
    }
    if (event.target == modalTermsOfUse) {
        modalTermsOfUse.style.display = "none";
    }
}
