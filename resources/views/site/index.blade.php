@extends('base')

@section('main')

	{!! getLinks('col-intro-slider', 'intro') !!}

	@include('site.blocks.sections.about')

    {!! getLinks('col-activities', 'activities') !!}

    {!! getNews('news') !!}

    {!! getLinks('col-partners', 'partners') !!}

@endsection
