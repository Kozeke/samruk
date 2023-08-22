<div
    style="{{$editing!==2?"width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')

    <p dir="ltr" style="line-height:1.3800000000000001;text-align: center;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:700;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Согласие на постоянную прописку</span>
    </p>
    <p dir="ltr" style="line-height:1.3800000000000001;text-align: center;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Заявление</span>
    </p>
    <form action="{{ $editing?url('/view/appeal'):url('/edit/appeal') }}" method="post">
        {!! csrf_field() !!}

        <p dir="ltr"
           style="line-height:1.3800000000000001;text-indent: 35pt;text-align: justify;margin-top:12pt;margin-bottom:12pt;">
        <span
            style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Прошу Вас дать согласие на регистрацию меня в Департаменте &quot;Центр обслуживания населения - филиала НАО &quot;Государственная корпорация &quot;Правительство для граждан&quot; по адресу:&nbsp;</span><span
                style="font-size:12pt;color:#000000;background-color:transparent;font-weight:400;font-style:italic;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">авто</span>
        </p>
        <p dir="ltr" style="line-height:1.3800000000000001;text-align: center;margin-top:12pt;margin-bottom:12pt;"><span
                style="font-size:12pt;color:#000000;background-color:transparent;font-weight:400;font-style:italic;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">авто</span><span
                style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp; &nbsp;</span><span
                style="font-size:10pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;(Ф.И.О.)</span>
        </p>
        <p style="text-align: left;"><strong>и членов моей семьи</strong></p>
        <span dir="ltr"
              style="font-size:13.999999999999998pt;line-height:1.3800000000000001;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;">1)</span>

        @if($editing)
            <span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['attachment_one']??""}}</span>
        @endif
        <input placeholder="(Ф.И.О., и степень родства)"
               style="width: 70%" type="{{$editing?"hidden":"text"}}" name="attachment_one"
               value="{{$data['attachment_one']??""}}"/>
        <p>
        </p>
        <span dir="ltr"
              style="font-size:13.999999999999998pt;line-height:1.3800000000000001;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;">2)</span>
        @if($editing)
            <span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['attachment_two']??""}}</span>
        @endif
        <input placeholder="(Ф.И.О., и степень родства)"
               style="width: 70%" type="{{$editing?"hidden":"text"}}" name="attachment_two"
               value="{{$data['attachment_two']??""}}"/>
        <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>
        <p dir="ltr" style="line-height:1.3800000000000001;margin-top:12pt;margin-bottom:12pt;"><span
                style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">на постоянное место жительство по адресу:&nbsp;</span><span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['JK']??""}}&nbsp;</span>
        <p dir="ltr" style="line-height:1.3800000000000001;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><br>
        </p>
        @if($editing !== 2)
            <div style="position: absolute; top: 8px;left: 550px">
                @if($editing === 0)
                    <div style="position: absolute">
                        {{ Form::submit(trans('translations.gb.view')) }}
                    </div>
                @endif
                @if($editing === 1)
                    <div style="position: absolute">
                        {{ Form::submit(trans('translations.gb.edit'), ['class' => 'btn btn--secondary']) }}
                    </div>
                @endif
            </div>
    </form>
    <div style="position: absolute; top:8px; left: 705px">
        <form action="{{url('/print/appeal')}}" method="post">`
            {!! csrf_field() !!}

            <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>
            <input type="hidden" name="attachment_one"
                   value="{{$data['attachment_one']??""}}"/>
            <input type="hidden" name="attachment_two"
                   value="{{$data['attachment_two']??""}}"/>
            <input type="hidden" name="reason"
                   value="{{$data['reason']??""}}"/>

            {{ Form::submit(trans('translations.gb.print')) }}

        </form>
        @endif
    </div>
    @include('appeals_pdf_templates.appeal_footer')

</div>
