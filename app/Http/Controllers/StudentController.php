<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Stage;

class StudentController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $student = Auth::user();

        // Security check
        if (!$student || $student->role !== 'student') {
            abort(403, 'Unauthorized access');
        }

        // Load relationships
        $student->load(['supervisor', 'project']);

        // Get project (safe)
        $project = $student->project ?? null;

        // Get stages ordered
        $stages = Stage::orderBy('order', 'asc')->get();

        return view('student.dashboard', compact('student', 'project', 'stages'));
    }

    // ================= SUBMIT TITLE =================
    public function submitTitle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $student = Auth::user();

        // prevent non-students
        if ($student->role !== 'student') {
            abort(403, 'Unauthorized');
        }

        // Create or update title
        Project::updateOrCreate(
            ['student_id' => $student->id],
            [
                'title' => trim($request->title),
                'status' => 'pending'
            ]
        );

        return redirect()->back()->with('success', 'Title submitted for approval');
    }
}