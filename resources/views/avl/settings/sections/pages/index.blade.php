@extends('avl.default')

@section('main')
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> {{$section->name_ru}}
        <div class="card-actions">
          <button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
        </div>
      </div>
      <div class="card-body">
				<input type="hidden" id="section_id" value="{{ $section->id }}">
        <form action="{{ url('/admin/settings/sections/'.$section->id.'/page/'.$section->page->id) }}" method="post" id="submit">
          {!! csrf_field(); !!}
          {{ method_field('PUT') }}
          <ul class="nav nav-tabs" role="tablist">
              @foreach($langs as $lang)
                <li class="nav-item">
                  <a class="nav-link @if($lang->key == "ru") active show @endif" href="#{{ $lang->key }}" data-toggle="tab"> {{ $lang->name }} </a>
                </li>
              @endforeach
								<li class="nav-item">
		              <a class="nav-link" href="#media" data-toggle="tab">Фото</a>
		            </li>
          </ul>
          <div class="tab-content">
            @foreach ($langs as $lang)
              @php $description = 'description_' . $lang->key; @endphp
              <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="{{$lang->key}}" role="tabpanel">
                <textarea class="form-control tinymce" name="page_description_{{$lang->key}}" rows="15">{{$section->page->$description}}</textarea>
              </div>
            @endforeach
						<div class="tab-pane" id="media" role="tabpanel">
              <div class="block--file-upload">
                <input id="upload--photos" name="upload" type="file" />
              </div>
              <div class="photo--page col-lg-12">
                <div class="row">
                  <ul id="sortable" class="list-unstyled">
                    @foreach ($images as $image)
                      <li class="col-md-2 float-left" id="mediaSortable_{{ $image['id'] }}">
                        <div class="card">
                          <div class="card-header">
                            <div class="row">
                              @php $classImage = ($image['good'] == 0) ? '-slash' : '' ; @endphp
                              <div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="change--status" data-model="PagesMedia" data-id="{{ $image['id'] }}"><i class="fa fa-eye<?=$classImage?>"></i></a></div>
                              <div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="deleteMedia" data-model="PagesMedia" data-id="{{ $image['id'] }}"><i class="fa fa-trash-o"></i></a> </div>
                            </div>
                          </div>
                          <div class="card-body p-0">
                            <img src="/image/resize/260/230/{{ $image['link'] }}">
                          </div>
                          <div class="card-footer p-0 bg-white border-0">
                            <ul class="nav nav-tabs">
                              @foreach($langs as $lang)
                                <li class="nav-item p-0">
                                  <a class="nav-link @if($lang->key == 'ru') active show @endif" href="#tab--title-item-{{ $image['id'] }}-{{ $lang->key }}" data-toggle="tab" aria-expanded="false">
                                    {{ $lang->key }}
                                  </a>
                                </li>
                              @endforeach
                            </ul>
                            <div class="tab-content">
                              @foreach($langs as $lang)
                                <div class="p-0 tab-pane @if($lang->key == 'ru') active show @endif" id="tab--title-item-{{ $image['id'] }}-{{ $lang->key }}">
                                  <input class="form-control border-0 media--{{ $image['id'] }}" type="text" value="{{ $image['title_' . $lang->key] }}" data-lang="{{ $lang->key }}" placeholder="{{ $lang->key }}">
                                  <button type="button" class="btn btn-primary btn-sm btn-block save--media-content" data-id="{{ $image['id'] }}">Save</button>
                                </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>

            </div>
          </div>
          <br/>
        </form>
      </div>
      <div class="card-footer position-relative">
        <i class="fa fa-align-justify"></i> {{$section->name_ru}}
        <div class="card-actions">
          <button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
        </div>
      </div>
    </div>
@endsection

@section('js')
	<script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
	<script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

	<script src="/avl/js/modules/settings/pages/index.js" charset="utf-8"></script>
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>
@endsection
