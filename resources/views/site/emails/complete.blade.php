<div style="width: 50%; margin:0 auto; padding: 15px; background: #f0f3f5; word-break: break-all;">
  <h4>Здравствуйте, {{ $user->profile->name }}!</h4>

  <p>Вы получили данное письмо так как ваше обращение было рассмотрено</p>
  <p>Обращение под номером : <b>{{ concatNumber($treatment->category, $treatment->id) }}</b> было рассмотрено </p>
  <p><b>Тема обращения:</b> <br/>
    {{ $treatment->theme }}
  </p>
  <p><b>Текст обращения:</b> <br/>
    {{ $treatment->message }}
  </p>
  <p><b>Текст ответа:</b> <br/>
    {!! $treatment->reply !!}
  </p>
  @if (count($treatment_files) != 0)
    <p><b>Прикрепленные файлы:</b></p>
    <ul style="list-style: none; padding-left: 15px;">
      @foreach($treatment_files as $files)
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
