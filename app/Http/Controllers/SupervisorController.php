<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;

class SupervisorController extends Controller
{
    /**
     * DASHBOARD 
     */
    public function dashboard()
    {
        $supervisor = Auth::user();

        // load students + projects
        $students = User::where('role', 'student')
            ->where('supervisor_id', $supervisor->id)
            ->with('project')
            ->get();

        return view('supervisor.dashboard', compact('supervisor', 'students'));
    }

    /**
     * STUDENTS PAGE
     */
    public function students()
    {
        $supervisor = Auth::user();

        $students = User::where('role', 'student')
            ->where('supervisor_id', $supervisor->id)
            ->get();

        return view('supervisor.students', compact('students', 'supervisor'));
    }

    /**
     * TITLES PAGE
     */
    public function titles()
    {
        $supervisor = Auth::user();

        $students = User::where('role', 'student')
            ->where('supervisor_id', $supervisor->id)
            ->with('project')
            ->get();

        return view('supervisor.titles', compact('students', 'supervisor'));
    }

    /**
     * VIEW SINGLE STUDENT
     */
    public function viewStudent($id)
    {
        $supervisor = Auth::user();

        $student = User::where('role', 'student')
            ->where('supervisor_id', $supervisor->id)
            ->where('id', $id)
            ->with('project')
            ->firstOrFail();

        return view('supervisor.student-view', compact('student'));
    }

    /**
     * APPROVE TITLE
     */
    public function approveTitle($id)
    {
        $project = Project::findOrFail($id);

        $project->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Title approved successfully');
    }

    /**
     * REJECT TITLE
     */
    public function rejectTitle($id)
    {
        $project = Project::findOrFail($id);

        $project->update([
            'status' => 'rejected'
        ]);

        return back()->with('error', 'Title rejected');
    }
}