
<!-- Breadcrumb -->
<ol class="breadcrumb">

  <li class="breadcrumb-item"><a href="/" target="_blank">Сайт</a></li>
  <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
  <li class="breadcrumb-item active">Dashboard</li>

  <!-- Breadcrumb Menu-->
  @if ($authUser->role->name == 'admin')
    @isset($section)
      @if (!is_null($section) && (!is_null($section->current_template)))
        <li class="breadcrumb-menu d-md-down-none">
          <div class="btn-group" role="group" aria-label="Button group">
            <a class="btn" href="{{ route('admin.settings.templates.edit', ['template' => $section->current_template->id]) }}"><i class="fa fa-sticky-note-o"></i> Шаблон</a>
            <a class="btn" href="{{ route('admin.settings.sections.edit', ['section' => $section->id]) }}"><i class="icon-settings"></i> Настройки</a>
          </div>
        </li>
      @endif
    @endisset
  @endif
</ol>

<div class="container-fluid">

    <div class="animated fadeIn">

        <div class="row">

            <div class="col-md-12">
                @yield('main')
            </div>

        </div>

    </div>

</div>
<!-- /.conainer-fluid -->
