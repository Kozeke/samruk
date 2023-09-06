<div
    style="width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke">
    @include('appeals_pdf_templates.appeal_header')
    <p>&nbsp;</p>
    <p style="text-align: center;"><strong>Частично досрочное погашение за счет ЕПВ&nbsp;</strong></p>
    <p style="text-align: center;"><strong>ЗАЯВЛЕНИЕ</strong></p>
    <p>&nbsp;</p>
    <span style="text-indent: 45px">Прошу Вас предоставить справку о задолженности в целях частично досрочного погашения остатка стоимости
        арендуемого мною жилого помещения, расположенного по адресу: {{$data['JK']??""}}
        согласно условий Договора аренды с выкупом жилого помещения от {{$data['date_from']??""}} года № {{$id??""}}
        авто (далее &ndash; Договор), по состоянию на
        {{$data['date_from']}}

        <input type="date" name="date_from"/> года, за счет
        денежных средств ЕПВ (доступная сумма
        <input type="number" name="price"/>
        {{$data['price']}} тенге).
    </span>
    <p><br></p>
</div>
@include('appeals_pdf_templates.appeal_footer')

