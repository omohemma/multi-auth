<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials =  $request->only($this->username(), 'password');

        if (Auth::guard('admin')->attempt($credentials,$request->filled('remember'))){
            return redirect()->intended(route( 'admin.home'));
        }
        return redirect()->back()->withInput($request->only('email,remember'));
    }



    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }





}
