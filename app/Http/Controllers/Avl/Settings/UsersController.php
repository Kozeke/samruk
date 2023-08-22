<?php namespace App\Http\Controllers\Avl\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\{User, Menu};
use View;

class UsersController extends AvlController
{

    protected $accessModel = null;

    public function __construct (Request $request) {
      parent::__construct($request);

			$this->accessModel = Menu::where('model', 'App\Models\User')->first();

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

      $users = User::where('role_id', '!=', 3);

      return view('avl.settings.users.index',[
          'users' => $users->paginate(20)
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

      $roles = [];
      foreach (\App\Models\Roles::where('name', '!=', 'admin')->get() as $role) {
        $roles[$role->id] = $role->display_name;
      }

      return view('avl.settings.users.create', [
        'roles' => $roles
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', $this->accessModel);

      $post = $this->validate(request(), [
        'email' => 'required|email|unique:users,email',
        'role_id' => 'sometimes|required|integer|min:1',
        'area_id' => 'sometimes|required|integer|min:1',
        'good' => 'sometimes|integer',
        'admin' => 'sometimes|integer',
        'iin' => '',
        'name' => 'required|min:2|max:100',
        'surname' => 'required|max:100',
        'patronymic' => 'max:100',
        'address' => 'max:255',
        'homephone' => 'max:100',
        'mobile' => 'max:100',
        'password' => 'required|min:5'
      ], [
        'email.required' => 'E-mail не указан',
        'email.email' => 'E-mail введен не верно',
        'email.unique' => 'E-mail уже зарегистрирован',
        'surname.required' => 'Фамилия не указана',
        'surname.min' => 'Фамилия не менее :min символов',
        'surname.max' => 'Фамилия не более :max символов',
        'name.required' => 'Имя не указано',
        'name.min' => 'Имя не менее :min символов',
        'name.max' => 'Имя не более :max символов',
        'role_id.required' => 'Роль пользователя не выбрана',
        'area_id.required' => 'Район не выбран',
      ]);

      $user = new User;

      $user->email = $post['email'];

      if ($post['password']) { $user->password = $post['password']; }
      $user->good = $post['good'] ?? 0;
      $user->admin = $post['admin'] ?? 0;
      $user->iin = $post['iin'];
      $user->name = $post['name'];
      $user->surname = $post['surname'];
      $user->patronymic = $post['patronymic'];
      $user->address = $post['address'];
      $user->homephone = $post['homephone'];
      $user->mobile = $post['mobile'];
      $user->role_id = $post['role_id'];
      $user->area_id = $post['area_id'];

      if ($user->save()) {
        return redirect()->route('users.index')->with(['success' => ['Сохранение прошло успешно!']]);
      }

      return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
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

      return view('avl.settings.users.show', [
          'user' => \App\Models\User::findOrFail($id)
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

      $roles = [];
      foreach (\App\Models\Roles::where('name', '!=', 'admin')->get() as $role) {
        $roles[$role->id] = $role->display_name;
      }

      return view('avl.settings.users.edit', [
          'user' => \App\Models\User::findOrFail($id),
          'roles' => $roles
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

      $post = $this->validate(request(), [
        'email' => 'required|email|unique:users,email,' . $id,
        'role_id' => 'sometimes|required|integer|min:1',
        'area_id' => 'sometimes|required|integer|min:1',
        'good' => 'integer',
        'admin' => 'integer',
        'iin' => '',
        'name' => 'required|min:2|max:100',
        'surname' => 'required|max:100',
        'patronymic' => 'max:100',
        'address' => 'max:255',
        'homephone' => 'max:100',
        'mobile' => 'max:100',
        'password' => $request->password != null ?'sometimes|required|min:5': ''
      ], [
        'email.required' => 'E-mail не указан',
        'email.email' => 'E-mail введен не верно',
        'email.unique' => 'E-mail уже зарегистрирован',
        'surname.required' => 'Фамилия не указана',
        'surname.min' => 'Фамилия не менее :min символов',
        'surname.max' => 'Фамилия не более :max символов',
        'name.required' => 'Имя не указано',
        'name.min' => 'Имя не менее :min символов',
        'name.max' => 'Имя не более :max символов',
        'role_id.required' => 'Роль пользователя не выбрана',
        'area_id.required' => 'Район не выбран',
      ]);

      $user = \App\Models\User::findOrFail($id);
      if ($user) {
        $user->email = $post['email'];

        if ($post['password']) { $user->password = $post['password']; }
        $user->good = $post['good'] ?? 0;
        $user->admin = $post['admin'] ?? 0;
        $user->iin = $post['iin'];
        $user->name = $post['name'];
        $user->surname = $post['surname'];
        $user->patronymic = $post['patronymic'];
        $user->address = $post['address'];
        $user->homephone = $post['homephone'];
        $user->mobile = $post['mobile'];

        if ($user->role->name != 'admin') { $user->role_id = $post['role_id']; }
        if ($user->role->name != 'admin') { $user->area_id = $post['area_id']; }

        if ($user->save()){
          return redirect()->route('users.index')->with(['success' => ['Сохранение прошло успешно!']]);
        }
      }
      return redirect()->route('users.edit', ['user' => $id])->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
