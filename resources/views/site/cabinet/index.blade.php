@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page-cabinet')
@endsection

@section('content')

    <section class="section cabinet">
        <div class="cabinet__inner container" data-aos="fade-up" data-aos-delay="200">
            @include('site.cabinet.snippets.header')

            <div class="cabinet__main w-100">

                @if ($data['code'] == 500)
                    <div class="alert alert--danger">{{ $data['message'] }}</div>
                @else
                    @if ($data['code'] != 200)
                        <div class="alert alert--info">{{ $data['message'] }}</div>
                    @else
                        {{$user['consent_to_data_collection']}}
                        @if ($user['consent_to_data_collection'])
                            @if ($profile_check_need)

                                @include('site.cabinet.snippets.check-profile')
                            @endif
                            <div class="row">
                                @foreach ($dogovor as $data)
                                    @include('site.cabinet.snippets.contract-card')
                                @endforeach
                                @else
                                    @include('site.auth.consent')
                                @endif
                            </div>
                        @endif
                    @endif

            </div>
        </div>
    </section>

@endsection
