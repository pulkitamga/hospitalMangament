<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Doctor;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     */
    public function index()
    {
        $departments = Department::with('doctor')->latest()->get();
        return view('admin.departments.index', compact('departments')); // ✅ Updated View Path
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        $doctors = Doctor::all();
        return view('admin.departments.create', compact('doctors')); // ✅ Updated View Path
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments,name',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'doctor_id' => 'required|exists:doctors,id',
            'status' => 'required|in:active,inactive',
        ]);

        // Photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('departments', 'public');
        }

        Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'photo_path' => $photoPath,
            'doctor_id' => $request->doctor_id,
            'status' => $request->status,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department created successfully!');
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department)
    {
        $doctors = Doctor::all();
        return view('admin.departments.edit', compact('department', 'doctors')); // ✅ Updated View Path
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'doctor_id' => 'required|exists:doctors,id',
            'status' => 'required|in:active,inactive',
        ]);

        // Photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('departments', 'public');
            $department->update(['photo_path' => $photoPath]);
        }

        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'doctor_id' => $request->doctor_id,
            'status' => $request->status,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully!');
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully!');
    }
}
