<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-scroll">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="google" content="notranslate">
    <meta name="description" content="{{ strip_tags($settings['description']) }}">
    <meta name="author" content="">
    <meta name="keyword" content="{{ strip_tags($settings['keywords']) }}">
    <meta name="_token" content="{{ csrf_token() }}">
    @php
        $sectionTitle = '';

        if (isset($section)) {
            if ($section->type == 'news') {
                if (isset($data)) {
                    $sectionTitle .= $data->title . ' | ';
                }
            }
            $sectionTitle .= $section->name . ' | ';
        }
    @endphp
    <title>{{ $sectionTitle . strip_tags($settings['title']) }}</title>

    @include('site.blocks.base.favicon')
    @include('site.blocks.base.open-graph')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    @include('site.blocks.base.styles')

    <script>
        window.Main = {
            locale: '{{ app()->getLocale() }}',
            isHome: {{ $indexPage ? 1 : 0 }}
        }
    </script>

    @if(env('APP_ENV') === 'production')
        @include('site.blocks.base.statistics')
        @endif
        //<style>
        //.wrap, img, .btn-side {
        //filter: grayscale(100%);
        //}
        //</style>    
</head>

@php
    $bodyClass = '';

    if (isTraur()) {
        $bodyClass .= specialTraur() . ' ';
    }

    $bodyClass = trim($bodyClass);
@endphp

<body @if($bodyClass) class="{{ $bodyClass }}" @endif>

