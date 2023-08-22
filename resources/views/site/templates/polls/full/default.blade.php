@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page')
@endsection

@section('content')
    @component('site.component.page')

        polls

    @endcomponent
@endsection
