<link rel="stylesheet" href="{{ mix('/site/cache/vendor.css') }}">
@yield('vendor-css')
<link rel="stylesheet" href="{{ mix('/site/cache/app.css') }}">
@if (isTraur())@endif
@yield('css')
