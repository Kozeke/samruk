// Get the modal
var modal = document.getElementById("myModal");
var modalConsentToDataCollection = document.getElementById("modalConsentToDataCollection");

// Get the button that opens the modal
var btnConsentToDataCollection = document.getElementById("btnConsentToDataCollection");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var spanConsentToDataCollection = document.getElementById("spanConsentToDataCollection");

// When the user clicks on the button, open the modal
if (modalConsentToDataCollection) {
    btnConsentToDataCollection.onclick = function () {
        if (modalConsentToDataCollection) {
            modalConsentToDataCollection.style.display = "block";
            modalConsentToDataCollection.scrollIntoView();
        }
    }
}
if (modal) {
    modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
if (span) {
    span.onclick = function () {
        modal.style.display = "none";
    }
}

if (spanConsentToDataCollection) {
    spanConsentToDataCollection.onclick = function () {
        modalConsentToDataCollection.style.display = "none";
    }
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
