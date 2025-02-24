<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('doctor')->latest()->get();
        $doctors = Doctor::all();
        return view('admin.departments.index', compact('departments', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments,name',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'doctor_id' => 'required|exists:doctors,id',
            'status' => 'required|in:active,inactive',
        ]);

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

        return response()->json(['success' => true, 'message' => 'Department created successfully!']);
    }

    public function edit(Department $department)
    {
        return response()->json(['success' => true, 'data' => $department]);
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id,
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'doctor_id' => 'required|exists:doctors,id',
            'status' => 'required|in:active,inactive',
        ]);

        $department->name = $request->name;
        $department->description = $request->description;
        $department->doctor_id = $request->doctor_id;
        $department->status = $request->status;

        if ($request->has('remove_photo')) {
            if ($department->photo_path) {
                Storage::disk('public')->delete($department->photo_path);
                $department->photo_path = null;
            }
        }

        if ($request->hasFile('photo')) {
            if ($department->photo_path) {
                Storage::disk('public')->delete($department->photo_path);
            }
            $department->photo_path = $request->file('photo')->store('departments', 'public');
        }

        $department->save();

        return response()->json(['success' => true, 'message' => 'Department updated successfully!']);
    }

    public function destroy($id)
{
    // Find the department and delete it
    $department = Department::findOrFail($id);

    // If department has an image, delete it
    if ($department->photo_path) {
        Storage::disk('public')->delete($department->photo_path);
    }

    // Delete the department record
    $department->delete();

    // Return a JSON response
    return response()->json(['success' => true, 'message' => 'Department deleted successfully!']);
}




}