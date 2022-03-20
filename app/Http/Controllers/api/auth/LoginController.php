<?php

namespace App\Http\Controllers\api\auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'phone' => ['required'],
            'password' => ['required'],
        ]);
        // dd($credentials);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return Auth::user();
        }
        return null;
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ]);
    }
}
