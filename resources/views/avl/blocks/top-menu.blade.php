
@if ($navClass == 'nav-link')<ul class="nav navbar-nav menu--admin">@endif

    @foreach ($items as $item)
        @if (count($item['children']) == 0)
            @if ($navClass == 'nav-link')<li class="nav-item px-3">@endif
                <a  class="{{ $navClass }}"
                    @if (!is_null($item['route'])) href="{{ route($item['route']) }}" @else href="{{ $item['url'] }}" @endif
                    target="{{ $item['target'] }}" >
                    @if($item['icon_class'])<i class="{{ $item['icon_class'] }}"></i>@endif
                    @if(is_null($item['parent_id'])) <span class="d-lg-down-none">{{ $item['title'] }}</span> @else <span>{{ $item['title'] }}</span> @endif
                  </a>
            @if ($navClass == 'nav-link')</li>@endif
        @else
            <li class="nav-item px-3 dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    @if($item['icon_class'])<i class="{{ $item['icon_class'] }}"></i>@endif
                    <span class="d-lg-down-none">{{ $item['title'] }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-left">
                    <div class="dropdown-header text-center">
                        <strong>{{ $item['title'] }}</strong>
                    </div>
                    @include('avl.blocks.top-menu', ['items' => $item['children'], 'navClass' => 'dropdown-item'])
                </div>
            </li>
        @endif
    @endforeach
@if ($navClass == 'nav-link')</ul>@endif
