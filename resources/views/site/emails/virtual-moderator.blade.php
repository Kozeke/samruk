<div style="width: 50%; margin:0 auto; padding: 15px; background: #f0f3f5; word-break: break-all;">
<h4>Здравствуйте!</h4>
<p>Поступило новое обращение.</p>

<p>Данные отправителя:</p>
<p>
  <b>ФИО:</b> {{ $user->profile->surname }} {{ $user->profile->name }} {{ $user->profile->patronymic }}<br/>
  <b>ИИН:</b> {{ $user->profile->iin }}<br/>
  <b>Телефон:</b> {{ $user->profile->mobile }} / {{ $user->profile->phone }}<br/>
  <b>E-mail: {{ $user->email }}</b>
</p>

<p><b>Номер обращения:</b> № {{ concatNumber($virtual->category, $virtual->id) }} </p>

<p><b>Тема обращения:</b></p>
{{ $virtual->theme }}
<p>--------------------------------------------------------------------------</p>
<p><b>Текст обращения:</b></p>
{{ $virtual->message }}
<p>--------------------------------------------------------------------------</p>

@if (count($virtual_files) != 0)
  <p><b>Прикрепленные файлы:</b></p>
  <ul style="list-style: none; padding-left: 15px;">
    @foreach($virtual_files as $files)
      <li>
        <span>{{ $loop->iteration }}.</span>
        <a href="{!!url("{$files->path}")!!}">
          <span>{{$files->title}}</span>
        </a>
      </li>
    @endforeach
  </ul>
@endif

<p>
  С уважением,<br/>
  Служба поддержки сайта {{ $_SERVER['SERVER_NAME'] }}
</p>
</div>
