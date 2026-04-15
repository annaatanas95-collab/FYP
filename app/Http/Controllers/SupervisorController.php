<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SupervisorController extends Controller
{
    /**
     * Supervisor Dashboard
     * Shows students assigned to this supervisor
     */
    public function dashboard()
    {
        $supervisor = Auth::user();

        // get students assigned to this supervisor
        $students = User::where('role', 'student')
            ->where('supervisor_id', $supervisor->id)
            ->get();

        return view('supervisor.dashboard', compact('students', 'supervisor'));
    }

    /**
     * View single student details
     */
    public function viewStudent($id)
    {
        $supervisor = Auth::user();

        $student = User::where('role', 'student')
            ->where('supervisor_id', $supervisor->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('supervisor.student-view', compact('student'));
    }
}