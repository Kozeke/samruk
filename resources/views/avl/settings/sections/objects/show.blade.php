@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Страница : {{$new->title_ru}}
          <div class="card-actions">
          <a href="{{ url('/admin/settings/sections/'.$id.'/news') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          </div>
      </div>
      <div class="card-body">
        <form action="{{ url('/admin/settings/sections/'.$id.'/news/'.$new->id) }}" method="post" id="submit">
          {!! csrf_field(); !!}

          <div class="form-group">
            <label for="news_published_at">Дата публикации</label>
            <span class="form-control">{{ $new->published_at }}</span>
          </div>
          <ul class="nav nav-tabs" role="tablist">
            @foreach($langs as $lang)
            @php $name = 'title_' . $lang->key; @endphp
            <li class="nav-item">
              <a class="nav-link @if($lang->key == 'ru') active show @endif" href="#title_{{ $lang->key }}" data-toggle="tab">
                {{ $lang->name }}
              </a>
            </li>
            @endforeach
          </ul>
          <div class="tab-content">
            @foreach ($langs as $lang)
            @php $name = 'title_' . $lang->key; @endphp
            <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="title_{{$lang->key}}" role="tabpanel">
              @if ($new->$name == "")
              <span class="form-control">Нет заголовка на данном языке</span>
              @else
              <span class="form-control">{{$new->$name}}</span>
              @endif
            </div>
            @endforeach
          </div></br>
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active show" href="#short" data-toggle="tab">Короткая новость</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#full" data-toggle="tab">Полная новость</a>
            </li>
          </ul>
        <div class="tab-content">
          <div class="tab-pane" id="full" role="tabpanel">
            <ul class="nav nav-tabs" role="tablist">
              @foreach($langs as $lang)
              <li class="nav-item">
                <a class="nav-link @if($lang->key == "ru") active show @endif" href="#full_{{ $lang->key }}" data-toggle="tab"> {{ $lang->name }} </a>
              </li>
              @endforeach
            </ul>
            <div class="tab-content">
              @foreach ($langs as $lang)
              @php $full = 'full_' . $lang->key; @endphp
              <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="full_{{$lang->key}}" role="tabpanel">
                @if ($new->$full == "")
                <span class="form-control">Нет полной новости на данном языке</span>
                @else
                <span class="form-control">{{$new->$full}}</span>
                @endif
              </div>
              @endforeach
            </div>
          </div>
          <div class="tab-pane active show" id="short" role="tabpanel">
            <ul class="nav nav-tabs" role="tablist">
              @foreach($langs as $lang)
              <li class="nav-item">
                <a class="nav-link @if($lang->key == "ru") active show @endif" href="#short_{{ $lang->key }}" data-toggle="tab"> {{ $lang->name }} </a>
              </li>
              @endforeach
            </ul>
            <div class="tab-content">
              @foreach ($langs as $lang)
              @php $short = 'short_' . $lang->key; @endphp
              <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="short_{{$lang->key}}" role="tabpanel">
                @if ($new->$short == "")
                <span class="form-control">Нет короткой новости на данном языке</span>
                @else
                <span class="form-control">{{$new->$short}}</span>
                @endif
              </div>
              @endforeach
            </div>
          </div>
        </div>
        </div>
          <br/>
        </form>
      </div>
    </div>
@endsection
