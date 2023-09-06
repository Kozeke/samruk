<script>
    window.MSInputMethodContext && document.documentMode && document.write('<script src="https://polyfill.io/v3/polyfill.min.js?features=default%2CNodeList.prototype.forEach%2CNumber.parseFloat%2CNumber.parseInt"><\/script>');
</script>
<script src="{{ mix('/site/cache/vendor.js') }}"></script>
<script src="{{ asset('/site/cache/modal.js') }}"></script>
@stack('vendor-js')
<script src="{{ mix('/site/cache/app.js') }}"></script>
@stack('js')
