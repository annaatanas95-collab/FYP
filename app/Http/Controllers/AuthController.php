<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // COORDINATOR + SUPERVISOR LOGIN (SHARED LOGIN PAGE)


    public function showLogin()
    {
        return view('auth.login'); // shared login for coordinator + supervisor
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // COORDINATOR
            if ($user->role === 'coordinator') {
                return redirect()->route('coordinator.dashboard');
            }

            // SUPERVISOR
            if ($user->role === 'supervisor') {
                return redirect()->route('supervisor.dashboard');
            }

            // if someone else tries using this login
            Auth::logout();
            return back()->withErrors([
                'username' => 'Unauthorized access for this login page'
            ]);
        }

        return back()->withErrors([
            'username' => 'Invalid credentials'
        ]);
    }

    // STUDENT LOGIN (UNCHANGED - YOUR CURRENT SYSTEM)
    

    public function showStudentLogin()
    {
        return view('student.login');
    }

    public function studentLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->role !== 'student') {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Unauthorized login for student portal'
                ]);
            }

            // first login password change check
            if ($user->must_change_password) {
                return redirect()->route('auth.showChangePassword');
            }

            return redirect()->route('student.dashboard');
        }

        return back()->withErrors([
            'username' => 'Invalid credentials'
        ]);
    }

    // CHANGE PASSWORD (STUDENT ONLY)

    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', 'Password updated successfully');
    }

    // LOGOUT (ALL USERS)

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.showLogin');
    }
}


