@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
@endsection

@section('main')
  <div class="card">
    <div class="card-header">
        <i class="fa fa-align-justify"></i> Переместить новость : {{ $new->title_ru }}
        <div class="card-actions">
          <a href="{{ url('/admin/settings/sections/'.$id.'/news') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
        </div>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.settings.sections.news.move.save', ['id' => $id, 'nws' => $new->id]) }}" method="post" id="submit">
        {!! csrf_field(); !!}

        <div class="form-group">
          <label for="new_section">Переместить в</label>
          <select id="new_section" name="new_section" class="form-control">
            <option selected value="0">------</option>
            @include('avl.settings.sections.blocks.parent-news', ['sections' => $structures, 'parent' => 0, 'current' => $id, 'pre' => '' ,'level' => 0])
          </select>
        </div>

      </form>
    </div>
  </div>
@endsection
