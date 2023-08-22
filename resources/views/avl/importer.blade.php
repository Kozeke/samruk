@extends('avl.default')

@section('main')
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Импортер новостей
        </div>
        <div class="card-body">

          <form action="{{ route('importer') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="category_id">Из категории материалов старого сайта:</label>
              <select id="category_id" name="category_id" class="form-control">
                @include('avl.blocks.categories_importer', ['categories' => $categories])
              </select>
            </div>

            <div class="form-group">
              <label for="rubric_id">В новостную рубрику нового сайта:</label>
              <select id="rubric_id" name="rubric_id" class="form-control">
                <option value="">Новости</option>
                @foreach($rubrics as $rubric)
                  <option value="{{ $rubric->id }}">{{ $rubric->title }}</option>
                @endforeach
              </select>
            </div>

            <input type="submit" class="btn btn-primary" onclick="this.disabled=true; this.value='Работаем...';" value="Импортировать">
          </form>

          @if($result)
            {{ $result }}
          @endif

        </div>
      </div>
    </div>
    <!--/.col-->

  </div>
@endsection
