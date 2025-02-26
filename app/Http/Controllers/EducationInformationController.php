<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EducationInformation;
use App\Models\User;
use Illuminate\Http\Request;

class EducationInformationController extends Controller
{
    // List All Education Information
    public function index()
    {
        $educations = EducationInformation::with('user')->get();
        $users = User::all();
        return view('admin.educations.index', compact('educations', 'users'));
    }

    // Store New Education using AJAX
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'institution' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $education = EducationInformation::create($request->all());

        return response()->json(['success' => true, 'message' => 'Education added successfully.', 'education' => $education]);
    }

    // Get Education Details
    public function show(EducationInformation $education)
    {
        return response()->json(['success' => true, 'data' => $education]);
    }

    // Update Education using AJAX
    public function update(Request $request, EducationInformation $education)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'institution' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $education->update($request->all());

        return response()->json(['success' => true, 'message' => 'Education updated successfully.', 'education' => $education]);
    }

    // Delete Education using AJAX
    public function destroy(EducationInformation $education)
    {
        $education->delete();
        return response()->json(['success' => true, 'message' => 'Education deleted successfully.']);
    }
}
