<?php

namespace App\Http\Controllers;

use App\Models\WorkLeave;
use App\Models\User;
use Illuminate\Http\Request;

class WorkLeaveController extends Controller
{
    /**
     * Display a listing of the work leaves.
     */
    public function index()
    {
        $workLeaves = WorkLeave::with('user')->latest()->get();
        $users = User::all();
        return view('admin.work_leaves.index', compact('workLeaves', 'users'));
    }

    /**
     * Store a newly created work leave.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'description' => 'nullable|string',
            'status' => 'required|in:approved,pending,rejected',
        ]);

        // Check for duplicate work leave
        $exists = WorkLeave::where('user_id', $request->user_id)
                            ->where('from_date', $request->from_date)
                            ->where('to_date', $request->to_date)
                            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This work leave is already added!'
            ], 422);
        }

        WorkLeave::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Work leave added successfully!'
        ]);
    }

    /**
     * Show the work leave details.
     */
    public function show($id)
    {
        $workLeave = WorkLeave::with('user')->find($id);
        if (!$workLeave) {
            return response()->json(['success' => false, 'message' => 'Work leave not found!']);
        }

        return response()->json(['success' => true, 'data' => $workLeave]);
    }

    /**
     * Show the work leave details for editing.
     */
    public function edit($id)
    {
        $workLeave = WorkLeave::find($id);
        if (!$workLeave) {
            return response()->json(['success' => false, 'message' => 'Work leave not found!']);
        }

        return response()->json(['success' => true, 'data' => $workLeave]);
    }

    /**
     * Update the specified work leave using AJAX.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'description' => 'nullable|string',
            'status' => 'required|in:approved,pending,rejected',
        ]);

        $workLeave = WorkLeave::find($id);
        if (!$workLeave) {
            return response()->json(['success' => false, 'message' => 'Work leave not found!']);
        }

        $workLeave->update($request->all());

        return response()->json(['success' => true, 'message' => 'Work leave updated successfully!']);
    }

    /**
     * Remove the specified work leave.
     */
    public function destroy($id)
    {
        $workLeave = WorkLeave::find($id);
        if (!$workLeave) {
            return response()->json(['success' => false, 'message' => 'Work leave not found!']);
        }

        $workLeave->delete();
        return response()->json(['success' => true, 'message' => 'Work leave deleted successfully!']);
    }
}
