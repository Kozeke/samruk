{{--<div--}}
{{--    style="{{$editing!==2?"border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">--}}
{{--    @include('appeals_pdf_templates.appeal_header')--}}
{{--    <div style="font-size: 14px;" v-if="selected_code_id==1">--}}
{{--        <p><br></p>--}}
{{--        <p style="text-align: center;font-size: 14px"><strong>Частично досрочное погашение</strong></p>--}}
{{--        <p style="text-align: center;"><strong>&nbsp;</strong></p>--}}
{{--        <p style="text-align: center;font-size: 14px"><strong>ЗАЯВЛЕНИЕ</strong></p>--}}
{{--        <p>&nbsp;</p>--}}

{{--        <p style="font-size: 14px">Настоящим прошу Вас разрешить внести на частично досрочное погашение сумму в--}}
{{--            размере {{$values['partial_early_repayment_of_the_amount']}}--}}
{{--            тенге по Договору аренды с выкупом жилого помещения от {{$data['date_d']??""}} года &nbsp;№{{$id??""}}, на--}}
{{--            {{$values['date_from']}}.--}}
{{--        <p><br></p>--}}
{{--        <p><br></p>--}}
{{--        <p><br></p>--}}

{{--    </div>--}}
{{--</div>--}}

{{--@include('appeals_pdf_templates.appeal_footer')--}}

<div>
    @include('appeals_pdf_templates.appeal_header')
    <div style="font-size: 14px;">
        <p><br></p>
        <p style="text-align: center;font-size: 14px"><strong>Частично досрочное погашение</strong></p>
        <p style="text-align: center;"><strong>&nbsp;</strong></p>
        <p style="text-align: center;font-size: 14px"><strong>ЗАЯВЛЕНИЕ</strong></p>
        <p>&nbsp;</p>

        <p style="font-size: 14px">Настоящим прошу Вас разрешить внести на частично досрочное погашение сумму в
            размере {{$values['partial_early_repayment_of_the_amount']??""}} тенге
            по Договору аренды с выкупом жилого помещения от {{$data['date_d']??""}} года &nbsp;№{{$id??""}},
            на {{$values['date_to_finish']??""}}
        <p><br></p>
        <p><br></p>
        <p><br></p>

    </div>
</div>

@include('appeals_pdf_templates.appeal_footer')



