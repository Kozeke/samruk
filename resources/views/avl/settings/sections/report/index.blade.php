@extends('avl.default')

@section('main')
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> {{$section->name_ru}}
        <div class="card-actions">
          <a href="{{ route('report.download') }}" class="btn" target="_blank">S</a>
          <button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
        </div>
      </div>
      <div class="card-body">
        @if ($reports->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td>#</td>
                  <td>ФИО</td>
                  <td>ИИН</td>
                  <td>Телефон</td>
                  <td>Зарегистрирован</td>
                </tr>
              </thead>
              <tbody>
                @php $iteration = 30 * ($reports->currentPage() - 1); @endphp
                @foreach ($reports as $report)
                  <tr>
                    <td>{{ ++$iteration }}</td>
                    <td>{{ $report->fio }}</td>
                    <td>{{ $report->iin }}</td>
                    <td>{{ $report->contacts }}</td>
                    <td>{{ $report->created_at }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="d-flex justify-content-end">
                {{ $reports->appends($_GET)->links('vendor.pagination.bootstrap-4') }}
            </div>
          </div>
        @endif
      </div>
      <div class="card-footer position-relative">
        <i class="fa fa-align-justify"></i> {{$section->name_ru}}
        <div class="card-actions">
          <a href="{{ route('report.download', ['short' => 'full']) }}" target="_blank" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Скачать"><i class="fa fa-download"></i></a>
        </div>
      </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>
@endsection
