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

    // Upload Students CSV

    public function uploadStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen($request->file('file'), 'r');

        fgetcsv($file); // skip header

        $rowsAdded = 0;
        $duplicates = 0;

        while (($row = fgetcsv($file)) !== false) {

            // Prevent errors if row is incomplete
            if(count($row) < 3) continue;

        $registrationNumber = trim($row[0]);
        $name = trim($row[1]);
        $supervisorName = isset($row[2]) ? trim($row[2]) : null;

        // Skip empty mandatory fields
        if(!$registrationNumber || !$name) continue;

        // Check duplicate
        if(User::where('registration_number', $registrationNumber)->exists()){
            $duplicates++;
            continue;
        }

        // Create student ONLY
        User::create([
            'name' => $name,
            'email' => $registrationNumber . '@student.com',
            'username' => $registrationNumber,
            'registration_number' => $registrationNumber,
            'password' => Hash::make('123456'),
            'role' => 'student',
            'must_change_password' => true,
            'supervisor_name' => $supervisorName // reference only
        ]);

            $rowsAdded++;
        }

        fclose($file);

        $message = "Students uploaded: $rowsAdded";
        if($duplicates > 0){
            $message .= " | Skipped duplicates: $duplicates";
        }

        return back()->with('success', $message);
    }

    public function deleteUploadedStudents()

    {
    $deleted = User::where('role', 'student')
                   ->where('must_change_password', true)
                   ->delete();

    return back()->with('success', "$deleted students deleted successfully");
    }
}