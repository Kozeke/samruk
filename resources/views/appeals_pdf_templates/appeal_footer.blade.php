<div style="color:black;font-size: 16px;font-weight:500;">
    <p>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</p>
    <p><br></p>
    <p><br></p>


    <p style="text-align: right;">{{$today_date??""}}</p>
    <div v-if="signed">
        <p style="text-align: right;">Подписано ЭЦП @{{signerFIO}}</p>
    </div>
    <div v-else>
        <p style="text-align: right;">Подпись:</p>
        <p style="text-align: right;">Код подпись от ЭЦП</p>
    </div>
</div>

