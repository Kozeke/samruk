@extends('avl.default')

@section('js')
  <script src="/avl/js/modules/settings/news/index.js" charset="utf-8"></script>
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> {{$section->name_ru}}
            @can('create', $section)
              <div class="card-actions">
                <a href="{{ route('admin.settings.sections.gallery.create', ['id' => $section->id]) }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
              </div>
            @endcan
        </div>
        <div class="card-body" style="owerflow:hidden; owerflow-x: true;">
            @if ($galleries)
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        @foreach($langs as $lang)
                          <th class="text-center" style="width: 20px">{{ $lang->key }}</th>
                        @endforeach
                          <th class="text-center">Название альбома</th>
                          <th class="text-center" style="width: 160px">Дата публикации</th>
                          <th class="text-center" style="width: 100px;">Действие</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($galleries as $gallery)
                          <tr class="position-relative" id="news--item-{{ $gallery->id }}">
                            @foreach($langs as $lang)
                              <td class="text-center" style="width: 20px">
                                <a class="change--status" href="#" data-id="{{ $gallery->id }}" data-model="Galleries" data-lang="{{$lang->key}}">@if ($gallery->{'good_' . $lang->key})<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i> @endif</a>
                              </td>
                            @endforeach
                            <td><b>{{ $gallery->title_ru }}</b></td>
                            <td class="text-center">{{ date('Y-m-d H:i', strtotime($gallery->published_at)) }}</td>
                            <td class="text-right">
                              <div class="btn-group" role="group">
                                @can('view', new App\Models\Sections) <a href="{{ route('admin.settings.sections.gallery.show', ['id' => $section->id, 'gallery_id' => $gallery->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan
                                @can('update', new App\Models\Sections) <a href="{{ route('admin.settings.sections.gallery.edit', ['id' => $section->id, 'gallery_id' => $gallery->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a> @endcan
                                {{-- @can('delete', new App\Models\Sections) <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a> @endcan --}}
                              </div>
                              @can('delete', $gallery)
                                <div class="remove-message">
                                    <span>Вы действительно желаете удалить запись?</span>
                                    <span class="remove--actions btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
                                        <button class="btn btn-outline-danger remove--news" data-id="{{ $gallery->id }}" data-section="{{ $section->id }}"><i class="fa fa-trash"></i> Да</button>
                                    </span>
                                </div>
                               @endcan
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $galleries->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
