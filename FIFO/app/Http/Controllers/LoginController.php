<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title'=> 'Login',
            'active' => 'login'
        ]);
    }
    //terima request dari method post di web.route
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required','min:3','max:255'],
            'password' => 'required'
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }
        return back()->with('loginError','login failed');

    }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');

    }
}
