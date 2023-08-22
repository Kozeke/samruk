<h4>Новый вопрос на сайте</h4>
<hr>
<p> <b>Имя:</b> {{ $gb->name }} </p>
<p> <b>Фамилия:</b> {{ $gb->surname }} </p>
<p> <b>Тема:</b> {{ $gb->theme }} </p>
<p> <b>E-mail:</b> {{ $gb->email }} </p>
<p> <b>Вопрос:</b> {{ $gb->message }} </p>
<hr>

<p>
  С уважением,<br/>
  Служба поддержки сайта {{ $_SERVER['SERVER_NAME'] }}
</p>
