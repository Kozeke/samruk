<div style=" font-family:'times_new_roman, DejaVu Sans, sans-serif;';font-size: 14px;">
    @include('appeals_pdf_templates.appeal_header')
    <div style="font-size: 12px">
        <p style=" text-align: center"><strong>Полный досрочный выкуп</strong></p>
        <p>&nbsp;</p>
        <p style="text-align: center;">
            <strong>ЗАЯВЛЕНИЕ</strong></p>
        <p>&nbsp;</p>
        Прошу Вас разрешить произвести полный досрочный выкуп арендуемого мною жилого помещения, расположенного по
        адресу: {{$data['JK']??""}}
        согласно условий Договора аренды с выкупом жилого помещения от
        {{$data['date_to']??""}} года № {{$contract_number??""}} (далее &ndash; Договор), по
        состоянию на {{$values['date_from']??""}} года.

    </div>
</div>
@include('appeals_pdf_templates.appeal_footer')
