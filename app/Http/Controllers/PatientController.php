<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Department;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Show all patients
    public function index()
    {
        $patients = Patient::with('department')->latest()->get();
        return view('admin.patients.index', compact('patients'));
    }

    // Show create form
    public function create()
    {
        $departments = Department::all();
        return view('admin.patients.create', compact('departments'));
    }

    // Store new patient
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'birthday' => 'required|date',
            'department_id' => 'required',
        ]);

        Patient::create($request->all());

        return redirect()->route('patients.index')->with('success', 'Patient added successfully.');
    }

    // Show single patient
    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    // Show edit form
    public function edit(Patient $patient)
    {
        $departments = Department::all();
        return view('admin.patients.edit', compact('patient', 'departments'));
    }

    // Update patient
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'birthday' => 'required|date',
            'department_id' => 'required',
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    // Delete patient (Soft Delete)
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
