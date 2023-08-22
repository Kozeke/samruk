<div style="width: 50%; margin:0 auto; padding: 15px; background: #f0f3f5; word-break: break-all;">
<h4>Здравствуйте, {{ $user->profile->name }}!</h4>
<p>Ваше обращение успешно отправлено.</p>

<p>При получении ответа на ваше обращение, вам будет выслано уведомление.</p>

<p>Вы так же сможете отслеживать ответ на ваше обращение в личном кабинете по номеру: № <b>{{ concatNumber($virtual->category, $virtual->id) }}</b>.</p>

<p>
  С уважением,<br/>
  Служба поддержки сайта {{ $_SERVER['SERVER_NAME'] }}
</p>
</div>
