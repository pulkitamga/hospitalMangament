<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Employee;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // List All Doctors
    public function index()
    {
        $doctors = Doctor::with('employee')->get();
        $employees = Employee::all(); 
        return view('admin.doctors.index', compact('doctors', 'employees'));
    }

    // Store New Doctor using AJAX
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $doctor = Doctor::create([
            'employee_id' => $request->employee_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Doctor added successfully.', 'doctor' => $doctor]);
    }

    // Get Doctor Details
    public function show(Doctor $doctor)
    {
        return response()->json(['success' => true, 'data' => $doctor]);
    }

    // Update Doctor using AJAX
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $doctor->update([
            'employee_id' => $request->employee_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Doctor updated successfully.', 'doctor' => $doctor]);
    }

    // Delete Doctor using AJAX
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response()->json(['success' => true, 'message' => 'Doctor deleted successfully.']);
    }
}
