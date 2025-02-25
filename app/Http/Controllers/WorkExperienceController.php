<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use App\Models\User;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    // List All Experiences
    public function index()
    {
        $experiences = WorkExperience::with('user')->get();
        $users = User::all(); 
        return view('admin.experiences.index', compact('experiences', 'users'));
    }

    // Store New Experience using AJAX
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'institution' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        $experience = WorkExperience::create([
            'user_id' => $request->user_id,
            'institution' => $request->institution,
            'field' => $request->field,
            'start_date' => $request->start_date,
        ]);

        return response()->json(['success' => true, 'message' => 'Experience added successfully.', 'experience' => $experience]);
    }

    // Get Experience Details
    public function show(WorkExperience $experience)
    {
        return response()->json(['success' => true, 'data' => $experience]);
    }

    // Update Experience using AJAX
    public function update(Request $request, WorkExperience $experience)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'institution' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        $experience->update([
            'user_id' => $request->user_id,
            'institution' => $request->institution,
            'field' => $request->field,
            'start_date' => $request->start_date,
        ]);

        return response()->json(['success' => true, 'message' => 'Experience updated successfully.', 'experience' => $experience]);
    }

    // Delete Experience using AJAX
    public function destroy(WorkExperience $experience)
    {
        $experience->delete();
        return response()->json(['success' => true, 'message' => 'Experience deleted successfully.']);
    }
}
