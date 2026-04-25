<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // COORDINATOR REGISTRATION
   
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
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

    // COORDINATOR + SUPERVISOR LOGIN
   
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // coordinator
            if ($user->role === 'coordinator') {
                return redirect()->route('coordinator.dashboard');
            }

            // supervisor
            if ($user->role === 'supervisor') {
                return redirect()->route('supervisor.dashboard');
            }

            Auth::logout();
            return back()->withErrors([
                'username' => 'Unauthorized access for this login page'
            ]);
        }

        return back()->withErrors([
            'username' => 'Invalid credentials'
        ]);
    }

    // STUDENT LOGIN (UNCHANGED)
   
    public function showStudentLogin()
    {
        return view('student.login');
    }

    public function studentLogin(Request $request)
    {
        $credentials = $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        if(Auth::attempt($credentials)){

            $user = Auth::user();

            if($user->role != 'student'){
                Auth::logout();
                return back()->withErrors([
                    'username'=>'Unauthorized login for student portal'
                ]);
            }

            if($user->must_change_password){
                return redirect()->route('auth.showChangePassword');
            }

            return redirect()->route('student.dashboard');
        }

        return back()->withErrors([
            'username'=>'Invalid credentials'
        ]);
    }

    // CHANGE PASSWORD
  
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
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

    // LOGOUT
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.showLogin');
    }
}


