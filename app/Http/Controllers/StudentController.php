<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // Dashboard view
    public function dashboard()
    {
        $user = Auth::user();

        // Ensure only students can access
        if($user->role !== 'student'){
            abort(403, 'Unauthorized access');
        }

        return view('student.dashboard');
    }

    // Here you can add other student functions in future
}