@if (isset($section))
    @if ($section->type === 'news')
        @if (isset($data))
            @php
                $cover = $data->media()->where('good', 1)->orderBy('main', 'DESC')->orderBy('sind', 'DESC')->first();
            @endphp

            <meta property="og:title" content="{{ $data->title }}">
            <meta property="og:type" content="article">
            <meta property="og:article:published_time" content="{{ date('Y-m-d H:i:s', strtotime($data->published_at)) }}">
            <meta property="og:url" content="{{ $data->url }}">
            <meta property="og:image" content="{{ !is_null($cover) ? asset($cover->link) : '/site/img/logo-lg.png' }}">
            <meta property="og:image:secure_url" content="{{ !is_null($cover) ? asset($cover->link) : '/site/img/logo-lg.png' }}">
            <meta property="og:site_name" content="{{ strip_tags($settings['title']) }}">
            <meta property="og:locale" content="ru_RU">
        @else
            <meta property="og:image" content="/site/img/logo-lg.png">
            <meta property="og:image:secure_url" content="/site/img/logo-lg.png">
        @endif
    @else
        <meta property="og:image" content="/site/img/logo-lg.png">
        <meta property="og:image:secure_url" content="/site/img/logo-lg.png">
    @endif
@else
    <meta property="og:image" content="/site/img/logo-lg.png">
    <meta property="og:image:secure_url" content="/site/img/logo-lg.png">
@endif
