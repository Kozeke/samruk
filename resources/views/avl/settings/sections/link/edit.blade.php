@extends('avl.default')

@section('main')
    <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> Редактирование : {{$section->name_ru}}
          <div class="card-actions">
            <button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
          </div>
      </div>
      <div class="card-body">
        <form action="{{ url('/admin/settings/sections/'.$id.'/link/'.$section->id) }}" method="post" id="submit">
          {!! csrf_field(); !!}
          {{ method_field('PUT') }}
          <div class="form-group">
            <label for="section_link">Ссылка</label>
            <input type="text" name="section_link" class="form-control" value="{{ $section->link}}">
          </div>
        </form>
      </div>
    </div>
@endsection
