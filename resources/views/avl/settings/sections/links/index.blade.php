@extends('avl.default')

@section('js')
  <script src="/avl/js/modules/settings/news/index.js" charset="utf-8"></script>
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> {{$section->name_ru}}
            @can('create', App\Models\News::class)
              <div class="card-actions">
                <a href="{{ url('/admin/settings/sections/'.$id.'/links/create') }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
              </div>
            @endcan
        </div>
        <div class="card-body">
            @if ($links)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                          @foreach($langs as $lang)
                          <th class="text-center" style="width: 20px">{{ $lang->key }}</th>
                          @endforeach
                            <th class="text-center">Наименование ссылки</th>
                            <th class="text-center" style="width: 160px">Дата публикации</th>
                            <th class="text-center" style="width: 160px">Создан</th>
                            <th class="text-center" style="width: 100px;">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($links as $link)
                          <tr class="position-relative">
                            @foreach($langs as $lang)
                            @php $good = 'good_' . $lang->key; @endphp
                            <td class="text-center" style="width: 20px">
                              <a class="change--status" href="#" data-id="{{ $link->id }}" data-model="Links" data-lang="{{$lang->key}}">@if ($link->$good)<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i> @endif</a>
                            </td>
                            @endforeach
                            <td>{{ $link->title_ru }}</td>
                            <td>{{ $link->published_at }}</td>
                            <td>{{ $link->created_at }}</td>
                            <td class="text-right">
                              <div class="btn-group" role="group">
                                @can('view', new App\Models\News) <a href="{{ route('links.show', ['id' => $id, 'link_id' => $link->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan
                                @can('update', new App\Models\News) <a href="{{ route('links.edit', ['id' => $id, 'link_id' => $link->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a> @endcan
                                @can('delete', new App\Models\News) <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a> @endcan
                              </div>
                              @can('delete', $link)
                                <div class="remove-message">
                                    <span>Вы действительно желаете удалить запись?</span>
                                    <span class="remove--actions btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
                                        <button class="btn btn-outline-danger remove--news" data-id="{{ $link->id }}" data-section="{{ $id }}"><i class="fa fa-trash"></i> Да</button>
                                    </span>
                                </div>
                               @endcan
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $links->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
