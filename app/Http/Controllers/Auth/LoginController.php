<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users',
        ]);
        
        $credential = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        
        $remember_me  = ( !empty( $request->remember_me ) ) ? TRUE : FALSE;

        if(\Auth::attempt($credential)){
            $user = User::where( ["username" => $credential['username']] )->first();
            
            \Auth::login($user, $remember_me);
            
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')->with(AlertFormatter::danger("Login Gagal"));
        
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}