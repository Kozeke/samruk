<?php namespace App\Http\Controllers\Avl\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\User;
use App\Models\Profile;

class ProfileController extends AvlController
{
  public function edit($id)
  {
    $this->authorize('view', new User);

    return view('avl.settings.profile.edit', [
        'user' => \App\Models\User::findOrFail($id),
        'roles' => \App\Models\Roles::where('name', '!=', 'admin')->get()
    ]);
  }

  public function update(Request $request, $id)
  {
    $this->authorize('update', new User);
    $rules = [
      'profile_email' => 'required|email|unique:users,email,' . $id,
      'profile_iin' => 'required|size:12',
      'profile_dob' => 'required',
      'profile_name' => 'required|min:2|max:100',
      'profile_surname' => 'max:100',
      'profile_patronymic' => 'max:100',
      'profile_adds' => 'max:255',
      'profile_phone' => 'max:100',
      'profile_mobile' => 'max:100',
      'profile_sex' => 'required|max:2|integer'
    ];

    if ($request->input('profile_password')) { $rules['profile_password'] = 'required|min:5'; }

    $post = $this->validate(request(), $rules);

    $user = \App\Models\User::findOrFail($id);
    if ($user) {
      $user->email = $post['profile_email'];
      if ($request->input('profile_password')) {
        $user->password = $post['profile_password'];
      }

      if ($user->save()){
        $profile = $user->profile;

        $profile->iin = $post['profile_iin'];
        $profile->dob = $post['profile_dob'];
        $profile->name = $post['profile_name'];
        $profile->surname = $post['profile_surname'];
        $profile->patronymic = $post['profile_patronymic'];
        $profile->adds = $post['profile_adds'];
        $profile->phone = $post['profile_phone'];
        $profile->mobile = $post['profile_mobile'];
        $profile->sex = $post['profile_sex'];
        $profile->save();

        return redirect()->route('profile.edit', ['profile' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
      }
    }
    return redirect()->route('profile.edit', ['user' => $id])->with(['errors' => ['Что-то пошло не так.']]);
  }
}
