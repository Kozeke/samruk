{{--@extends('site.registrations.base')--}}

{{--@push('js')--}}
{{--    <script src="{{ asset('/site/js/appeals.js')}}"></script>--}}
{{--@endpush--}}

<form action="{{ url('/get/appeal') }}" method="post">
    {!! csrf_field(); !!}
{{--    <a href="javascript:;" onchange="getAppeals()">click</a>--}}
{{--    <select href="javascript:;" name="chosen_appeal_id" onchange="getAppeals();">--}}
    <select name="chosen_appeal_id" >

        @foreach($appeals as $index => $appeal)
            @if(isset($chosen_appeal_id) && $chosen_appeal_id == $index)
                <option selected value="{{$index}}">{{$appeals[$chosen_appeal_id]['title']}}</option>
            @else
                <option value="{{$index}}">{{$appeal['title']}}</option>
            @endif
        @endforeach
    </select>
    {{--<button  type="submit">Отправить</button>--}}

    {{ Form::submit(trans('translations.gb.send'), ['class' => 'btn btn--secondary']) }}

</form>
@if(isset($appeal_chosen_view))
    @include('appeals_pdf_templates.'.$appeal_chosen_view)
@endif
