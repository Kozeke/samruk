{{--@extends('site.registrations.base')--}}

{{--@push('js')--}}
{{--    <script src="{{ asset('/site/js/appeals.js')}}"></script>--}}
{{--@endpush--}}

<form action="{{ url('cabinet/users/excel') }}" method="post">
    <input id="inputFile" type="file" onChange="convertToBase64();"/>

    <script type="text/javascript">
        function convertToBase64() {
            //Read File
            var selectedFile = document.getElementById("inputFile").files;
            //Check File is not Empty
            if (selectedFile.length > 0) {
                // Select the very first file from list
                var fileToLoad = selectedFile[0];
                // FileReader function for read the file.
                var fileReader = new FileReader();
                var base64;
                // Onload of file read the file content
                // console.log(fileToLoad)
                console.log(data);
                fileReader.onload = function(fileLoadedEvent) {
                    base64 = fileLoadedEvent.target.result;
                    // Print data in console

                    console.log(base6/4);
                };
                // Convert data to base64
                fileReader.readAsDataURL(fileToLoad);
            }
        }
    </script>
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
