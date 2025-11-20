<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
      if (auth()->check()) {
        return redirect()->route('home');
      }
      return view('auth.login');
    }

    public function login(Request $request){
      $request->validate([
          'username' => 'required',
          'password' => 'required'
      ]);

      // attempt login
      $credentials = $request->only('username', 'password');
      
      if (Auth::attempt($credentials)) {
          $request->session()->regenerate();  // security
          return redirect()->intended('/');
      }

      return back()->withErrors([
          'username' => 'Username atau password salah.',
      ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
