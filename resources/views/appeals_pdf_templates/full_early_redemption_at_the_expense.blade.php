<div
    style="{{$editing!==2?"width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')
    <div>
        <p style="text-align: center;"><strong>Полный досрочный выкуп за счет ЕПВ</strong></p>
        <p>&nbsp;</p>
        <p style="text-align: center;"><strong>ЗАЯВЛЕНИЕ</strong></p>
        <p>&nbsp;</p>
        <span style="text-indent: 45px">Прошу Вас предоставить справку о задолженности в целях полного погашения остатка стоимости арендуемого мною жилого помещения, расположенного по адресу:&nbsp;{{$data['JK']??""}}&nbsp;</span>
            согласно условий Договора аренды с выкупом жилого помещения от {{$data['date_d']}} года № {{$id}} (далее &ndash; Договор), по состоянию на
            {{$data['date_from']}} года , за счет денежных средств ЕПВ (доступная сумма {{$data['price']}} тенге).
        </span>
    </div>

    @include('appeals_pdf_templates.appeal_footer')

</div>
