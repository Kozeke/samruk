<?php namespace App\Http\Controllers\Avl\Auth;

use App\Http\Controllers\Avl\AvlController;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends AvlController
{

    public function index() {
        return redirect('admin/auth/login');
    }

    public function login () {
        return view('avl.auth.login');
    }

    public function auth (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|max:255',
            'password' => 'required',
            // 'remember' => 'boolean'
        ]);

        $email     = $request->input('email');
        $password  = $request->input('password');
        // $remember  = $request->input('remember');

        if (!$validator->fails()) {

            if (Auth::attempt(['email' => $email, 'password' => $password], true)) {

                if (Auth::user()->good == 1 && Auth::user()->admin == 1) {
                    return redirect()->route('home');
                }
                return redirect('admin/auth/logout');

            } else {
                $validator->errors()->add('field', 'E-mail или пароль введены не верно.');
            }
        }
        // dd($validator->errors());
        return redirect()->back()->withErrors($validator->errors())->withInput();
    }

    public function logout (Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('admin/auth/login');
    }

}
