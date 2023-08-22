@extends('avl.default')

@section('js')
  <script src="/avl/js/modules/settings/news/index.js" charset="utf-8"></script>
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Настройка рубрик - разделы
        </div>
        <div class="card-body">
          @if ($sections)
            <ul class="list-group">
              @include('avl.blocks.rubrics', ['sections' => $sections, 'pre' => '', 'level' => 0])
            </ul>
          @endif
        </div>
    </div>
@endsection
