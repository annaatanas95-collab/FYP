<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CoordinatorController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        return view('coordinator.dashboard');
    }

    // Upload CSV Students
    public function uploadStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen($request->file('file'), 'r');
        fgetcsv($file); // skip header row

        $rowsAdded = 0;
        $duplicates = 0;

        // get existing registration numbers (fast check)
        $existingUsers = User::pluck('registration_number')->toArray();

        $data = [];

        while (($row = fgetcsv($file)) !== false) {

            if (count($row) < 3) continue;

            $registrationNumber = trim($row[0]);
            $name = trim($row[1]);
            $supervisorName = trim($row[2]);

            if (!$registrationNumber || !$name) continue;

            // skip duplicates
            if (in_array($registrationNumber, $existingUsers)) {
                $duplicates++;
                continue;
            }
            $supervisorNameClean = preg_replace('/\s+/', ' ', trim(strtolower($supervisorName)));

                $supervisor = User::where('role', 'supervisor')
                    ->get()
                    ->first(function ($sup) use ($supervisorNameClean) {
                        $dbName = preg_replace('/\s+/', ' ', trim(strtolower($sup->name)));
                    return $dbName === $supervisorNameClean;
            });

            $data[] = [
                'name' => $name,
                'email' => $registrationNumber . '@student.com',
                'username' => $registrationNumber,
                'registration_number' => $registrationNumber,
                'password' => Hash::make('123456'),
                'role' => 'student',
                'must_change_password' => true,

                // 🔥 IMPORTANT FIX
                'supervisor_id' => $supervisor ? $supervisor->id : null,
                'supervisor_name' => $supervisorName,

                'created_at' => now(),
                'updated_at' => now(),
            ];

            $rowsAdded++;

            // insert in chunks
            if (count($data) == 100) {
                User::insert($data);
                $data = [];
            }
        }

        fclose($file);

        // insert remaining
        if (!empty($data)) {
            User::insert($data);
        }

        $message = "Students uploaded: $rowsAdded";

        if ($duplicates > 0) {
            $message .= " | Skipped duplicates: $duplicates";
        }

        return back()->with('success', $message);
    }

    // Delete uploaded students
    public function deleteUploadedStudents()
    {
        $deleted = User::where('role', 'student')
            ->where('must_change_password', true)
            ->delete();

        return back()->with('success', "$deleted students deleted successfully");
    }

    // Show supervisor register form
    public function showRegisterSupervisor()
    {
        return view('coordinator.register-supervisor');
    }

    // Register supervisor
    public function registerSupervisor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6',
        ]);

        $supervisor = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'supervisor',
        ]);

        // auto assign students from CSV
        User::where('role', 'student')
            ->whereRaw('LOWER(TRIM(supervisor_name)) = ?', [strtolower($supervisor->name)])
            ->update([
                'supervisor_id' => $supervisor->id
            ]);

        return redirect()->route('coordinator.dashboard')
            ->with('success', 'Supervisor registered successfully!');
    }

    // Show supervisors
    public function showSupervisors()
    {
        $supervisors = User::where('role', 'supervisor')->get();
        return view('coordinator.supervisors', compact('supervisors'));
    }

    // Delete supervisor
    public function deleteSupervisor($id)
    {
        $supervisor = User::where('id', $id)
            ->where('role', 'supervisor')
            ->firstOrFail();

        $supervisor->delete();

        return back()->with('success', 'Supervisor deleted successfully');
    }

    // Update supervisor
    public function updateSupervisor(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'username' => 'required|string|unique:users,username,' . $request->id,
        ]);

        $supervisor = User::findOrFail($request->id);

        $supervisor->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
        ]);

        return back()->with('success', 'Supervisor updated successfully');
    }
}