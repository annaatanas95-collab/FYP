<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // show register
    public function showRegister(){
        return view('auth.register');
    }
    //register user
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users',
            'username'=>'required|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
        ]);
        Auth::login($user);
        return redirect('/login')->with('success', 'Account created successfully, please login');
    }

    //show login
    public function showLogin(){
        return view('auth.login');
    }

    //login user
    public function login(Request $request){
        $credentials = $request->validate([
            'username'=>'required',
            'password'=>'required'

        ]);
        if(Auth::attempt($credentials)){
           return redirect('/coordinatordashboard');
        }
        return back()->withErrors([
            'username'=>'invalid credentials'
        ]);
    }

    // logout
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
