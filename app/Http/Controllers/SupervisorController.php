<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;
use App\Models\Stage;
use App\Models\ProjectStage;

class SupervisorController extends Controller
{
    /**
     * DASHBOARD 
     */
    public function dashboard()
    {
        $supervisor = Auth::user();

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
            ->with('project.stages.stage')
            ->firstOrFail();

        return view('supervisor.student-view', compact('student'));
    }

    /**
     * APPROVE TITLE + AUTO CREATE STAGES 
     */
    public function approveTitle($id)
    {
        $project = Project::findOrFail($id);

        $project->update([
            'status' => 'approved'
        ]);

        $stages = Stage::orderBy('order')->get();

        foreach ($stages as $stage) {
            ProjectStage::firstOrCreate([
                'project_id' => $project->id,
                'stage_id' => $stage->id,
            ]);
        }

        return redirect()->route('supervisor.dashboard')
            ->with('success', 'Title approved & stages created');
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

        return redirect()->route('supervisor.dashboard')
            ->with('error', 'Title rejected');
    }
    /**
     * UPDATE PROJECT STAGE 
     */
    public function updateStage(Request $request, $id)
    {
        $request->validate([
            'deliverable' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        $projectStage = ProjectStage::findOrFail($id);

        $projectStage->update([
            'deliverable' => $request->deliverable,
            'deadline' => $request->deadline,
            'is_open' => $request->has('is_open') ? 1 : 0,
        ]);

        return back()->with('success', 'Stage updated successfully');
    }
}