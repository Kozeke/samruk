@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
          <i class="fa fa-align-justify"></i> No work
          <div class="card-actions">
          <a href="{{ url('/admin/settings/sections/'.$section->id.'/services') }}" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          </div>
      </div>
      <div class="card-body">
        пока не работает
      </div>
    </div>
@endsection
