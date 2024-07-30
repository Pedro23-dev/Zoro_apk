<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function handleLogin(AuthRequest $request)
    {
        // dd($request -> only(['email', 'password']));
        $credentials =$request -> only(['email', 'password']);
        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard'); 
        }else{
            return redirect()->back()->with('error_msg','Parametre de connexion non reconnue');
        }
    }
}


