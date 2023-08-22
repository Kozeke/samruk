<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="#" style="background-image: url('/avl/img/irsite_logo.svg'); background-size: 155px 28px;"></a>

    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    @include('avl.blocks.top-menu', ['items' => menu(), 'navClass' => 'nav-link'])

    <ul class="nav navbar-nav ml-auto">
        {{-- <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"><i class="icon-bell"></i><span class="badge badge-pill badge-danger">5</span></a>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"><i class="icon-list"></i></a>
        </li> --}}
        <li class="nav-item d-md-down-none">
          {{-- @if ($authUser->role->name == 'admin')
            {{ Form::select(null, $areas, $userArea ?? 1, ['class' => 'form-control change--area-control', 'style' => 'width: 200px;']) }}
          @else
            <span class="badge badge-primary" style="font-size: 18px; font-weight: normal;">{{ str_limit($authUser->area->title, 30) }}</span>
          @endif --}}
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="{{ '/image/resize/50/50' }}@if (!$authUser->photo == ''){{ $authUser->photo }} @else{{ '/data/profile/no-profile-photo.jpg' }}@endif" class="img-avatar" alt="{{ $authUser->email }}">
                <span class="d-md-down-none">{{ $authUser->email }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="/admin/settings/profile/{{ $authUser->id }}/edit"><i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="/admin/auth/logout"><i class="fa fa-lock"></i> Logout</a>
            </div>
        </li>
    </ul>
    {{-- aside-menu-toggler --}}
    <button class="navbar-toggler " type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>
