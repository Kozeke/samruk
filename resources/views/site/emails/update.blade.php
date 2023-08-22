<div style="width: 50%; margin:0 auto; padding: 15px; background: #f0f3f5; word-break: break-all;">
<h4>Здравствуйте, {{ $user->profile->name }}!</h4>
<p>Вы получили данное письмо так как изменился статус вашего обращения</p>
<p>Статус обращения под номером : <b>{{ concatNumber($treatment->category, $treatment->id) }}</b> был изменен на :  {{config('avl.statuses')[$treatment->status]}} </p>
<p>
  С уважением,<br/>
  Служба поддержки сайта {{ $_SERVER['SERVER_NAME'] }}
</p>
</div>
