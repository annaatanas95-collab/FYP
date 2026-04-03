<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Coordinator Registration

    public function showRegister() {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    public function register(Request $request) {
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
            'role'=>'coordinator', 
        ]);

        Auth::login($user);

        return redirect()->route('auth.showLogin')
                         ->with('success','Account created successfully, please login');
    }

    // Coordinator Login
    
    public function showLogin() {
        return view('auth.login'); 
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        if(Auth::attempt($credentials)){
            $user = Auth::user();

            if($user->role != 'coordinator'){
                Auth::logout();
                return back()->withErrors([

                        'username' => 'Access denied. Please use the correct login page.'
                    ]);
            }

            return redirect()->route('coordinator.dashboard');
        }

        return back()->withErrors(['username'=>'Invalid credentials']);
    }
    // Student Login
    
    public function showStudentLogin() {
        return view('student.login'); 
    }

    public function studentLogin(Request $request) {
        $credentials = $request->validate([
            'username'=>'required', // registration number
            'password'=>'required'
        ]);

        if(Auth::attempt($credentials)){
            $user = Auth::user();

            if($user->role != 'student'){
                Auth::logout();
                return back()->withErrors(['username'=>'Unauthorized login for this page']);
            }

            // First login check
            if($user->must_change_password){
                return redirect()->route('auth.showChangePassword');
            }

            return redirect()->route('student.dashboard');
        }

        return back()->withErrors(['username'=>'Invalid credentials']);
    }

    // Change Password (student only)

    public function showChangePassword() {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'password'=>'required|min:6|confirmed'
        ]);

        $user = Auth::user();
        $user->update([
            'password'=>Hash::make($request->password),
            'must_change_password'=>false
        ]);

        return redirect()->route('student.dashboard')
                         ->with('success','Password updated successfully!');
    }

    // Logout

    public function logout() {
        Auth::logout();
        return redirect()->route('auth.showLogin');
    }
}


