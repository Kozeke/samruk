@foreach ($sections as $section)
  <tr>
    <td class="p-2">
      <div class="sections--tree-name">
        @if($level > 0)<span class="delimetr">{{ delimetr($pre, $level) }}</span>@endif
        <span>{{ $section['name_ru'] }}</span>
      </div>
    </td>

    <td class="text-center p-2">
      <label class="switch switch-text switch-info-outline-alt switch-sm m-0">
        <input class="switch-input switch--input-read" type="checkbox" name="permission[{{ 'App\Models\Sections' }}][{{ $section['id'] }}][read]" value="1"
              @if (isset($permissions['App\Models\Sections']))
                @if (array_key_exists($section['id'], $permissions['App\Models\Sections']))
                  @if($permissions['App\Models\Sections'][$section['id']]['read'] == 1)
                    checked="" 1
                  @endif
                @endif
              @endif
        >
        <span class="switch-label" data-on="On" data-off="Off"></span>
        <span class="switch-handle"></span>
      </label>
    </td>
    <td class="text-center p-2">
      <label class="switch switch-text switch-primary-outline-alt switch-sm m-0">
        <input class="switch-input switch--input-add" type="checkbox" name="permission[{{ 'App\Models\Sections' }}][{{ $section['id'] }}][add]" value="1"
              @if (isset($permissions['App\Models\Sections']))
                @if (array_key_exists($section['id'], $permissions['App\Models\Sections']))
                  @if($permissions['App\Models\Sections'][$section['id']]['add'] == 1)
                    checked="" 1
                  @endif
                @endif
              @endif
        >
        <span class="switch-label" data-on="On" data-off="Off"></span>
        <span class="switch-handle"></span>
      </label>
    </td>
    <td class="text-center p-2">
      <label class="switch switch-text switch-success-outline-alt switch-sm m-0">
        <input class="switch-input switch--input-edit" type="checkbox" name="permission[{{ 'App\Models\Sections' }}][{{ $section['id'] }}][edit]" value="1"
              @if (isset($permissions['App\Models\Sections']))
                @if (array_key_exists($section['id'], $permissions['App\Models\Sections']))
                  @if($permissions['App\Models\Sections'][$section['id']]['edit'] == 1)
                    checked="" 1
                  @endif
                @endif
              @endif
        >
        <span class="switch-label" data-on="On" data-off="Off"></span>
        <span class="switch-handle"></span>
      </label>
    </td>
    <td class="text-center p-2">
      <label class="switch switch-text switch-danger-outline-alt switch-sm m-0">
        <input class="switch-input switch--input-delete" type="checkbox" name="permission[{{ 'App\Models\Sections' }}][{{ $section['id'] }}][delete]" value="1"
              @if (isset($permissions['App\Models\Sections']))
                @if (array_key_exists($section['id'], $permissions['App\Models\Sections']))
                  @if($permissions['App\Models\Sections'][$section['id']]['delete'] == 1)
                    checked="" 1
                  @endif
                @endif
              @endif
        >
        <span class="switch-label" data-on="On" data-off="Off"></span>
        <span class="switch-handle"></span>
      </label>
    </td>
  </tr>
  @if(count($section['children']) > 0)
    @include('avl.settings.roles.structures', ['sections' => $section['children'], 'pre' => '&#8594; ', 'level' => $level + 1 ])
  @endif
@endforeach
