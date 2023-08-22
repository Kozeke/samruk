<?php namespace App\Http\Controllers\Avl\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\{Menu, Roles};
use View;

class RolesController extends AvlController
{

    protected $accessModel = null;

    public function __construct (Request $request) {
      parent::__construct($request);

      $this->accessModel = Menu::where('model', 'App\Models\Roles')->first();

      View::share('accessModel', $this->accessModel);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $this->authorize('view', $this->accessModel);

      return view('avl.settings.roles.index', [
          'roles' => Roles::paginate(20)
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', $this->accessModel);

      return view('avl.settings.roles.create', [
        'menus' => \App\Models\Menu::all(),
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
      $this->authorize('create', $this->accessModel);

      $post = $this->validate(request(), [
          'button' => 'required|in:add,save',
          'role_name' => 'required|unique:roles,name|regex:/^[a-z]+$/i',
          'role_display_name' => 'required|min:5'
      ]);
      $create = \App\Models\Roles::create([
          'name' => $post['role_name'],
          'display_name' => $post['role_display_name']
      ]);

      if ($create) {
        if ($post['button'] == 'add') {
            return redirect()->route('admin.settings.roles.create')->with(['success' => ['Сохранение прошло успешно!']]);
        }
        return redirect()->route('admin.settings.roles.index')->with(['success' => ['Сохранение прошло успешно!']]);
      }

      return redirect()->route('admin.settings.roles.create')->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $this->authorize('view', $this->accessModel);

      $permissionRole = Roles::find($id)->permissions()->get();

      $permissions = [];
      foreach ($permissionRole as $permission) {
        if ($permission->model == 'App\Models\Menu') {
          $permissions[$permission->model][$permission->model_id] = $permission->toArray();
        } else {
          $permissions[$permission->model]= $permission->toArray();
        }
      }
      return view('avl.settings.roles.show', [
          'role' => \App\Models\Roles::findOrFail($id),
          'menus' => \App\Models\Menu::all(),
          'permissions' => $permissions
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $this->authorize('update', $this->accessModel);

      $permissionRole = Roles::find($id)->permissions()->get();

      $permissions = [];
      foreach ($permissionRole as $permission) {
        if ($permission->model == 'App\Models\Menu') {
          $permissions[$permission->model][$permission->model_id] = $permission->toArray();
        } else {
          $permissions[$permission->model][$permission->model_id]= $permission->toArray();
        }
      }
      // dd($permissions);
      return view('avl.settings.roles.edit', [
        'role' => Roles::findOrFail($id),
        'menus' => \App\Models\Menu::all(),
        'permissions' => $permissions
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->authorize('update', $this->accessModel);

      $role = Roles::find($id);
      $role->display_name = $request->input('role_display_name');

      if ($role->save()) {
        $role->permissions()->delete();

        $permissions = $request->input('permission');
        $permission = [];
        if (!is_null($permissions)) {
          foreach ($permissions as $model => $datum) {
            foreach ($datum as $model_id => $perm) {
              $perm = array_add($perm, 'role_id', $id);
              $perm = array_add($perm, 'model', $model);
              $perm = array_add($perm, 'model_id', $model_id);

              $permission = new \App\Models\Permissions($perm);
              $role->permissions()->save($permission);
            }
          }
        }
      }

      return redirect()->route('admin.settings.roles.index')->with(['success' => ['Сохранение прошло успешно!']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->authorize('delete', $this->accessModel);

      $role = Roles::find($id);
      if ($role) {
        if ($role->name != 'admin') {
          $users = $role->users()->get();
          if ($users) {
            foreach ($users as $user) {
              $user->role_id = null;
              $user->save();
            }
          }
          $role->permissions()->delete();

          if ($role->delete()) {
            return ['success' => ['Роль удалена.']];
          }
        }
      }

      return ['errors' => ['Что-то пошло не так']];
    }
}
