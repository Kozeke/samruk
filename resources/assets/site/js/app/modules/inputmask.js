document.addEventListener('DOMContentLoaded', () => {

    if (window.MaskInput) {
        new MaskInput('[data-input-phone]', { mask: "+7 (###) ### ## ##" });
    }

});
