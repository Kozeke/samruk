<div style="color:black;font-size: 16px;font-weight:500;">
    <p>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</p>
    <p><br></p>
    <p><br></p>


    <p style="text-align: right;">{{$today_date??""}}</p>
    <div v-if="signed">
        <p style="text-align: right;">Подписано ЭЦП</p>
        <p style="text-align: right;"> @{{signerFIO}}</p>
        <p style="font-size: 10px">Осы құжат "Электрондық құжат және электрондық цифрлық қолтаңба туралы" Қазақстан Республикасының 2003 жылғы 7
            қаңтардағы N 370-II Заңы 7 бабының 1 тармағына сәйкес қағаз тасығыштағы құжатпен бірдей.
            Данный документ согласно пункту 1 статьи 7 ЗРК от 7 января 2003 года N370-II "Об электронном документе и электронной цифровой подписи" равнозначен документу на бумажном носителе.</p>
    </div>
    <div v-else>
        <p style="text-align: right;">Подпись:</p>
        <p style="text-align: right;">Код подпись от ЭЦП</p>

    </div>
</div>

