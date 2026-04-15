<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // Dashboard view
    public function dashboard()
    {
        $student = Auth::user();

        // Ensure only students can access
        if ($student->role !== 'student') {
            abort(403, 'Unauthorized access');
        }

        // LOAD supervisor relationship
        $student->load('supervisor');

        return view('student.dashboard', compact('student'));
    }
}