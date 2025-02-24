<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use Illuminate\Http\Request;

class LabTestController extends Controller
{
    /**
     * Display a listing of the lab tests.
     */
    public function index()
    {
        $labTests = LabTest::latest()->get();
        return view('admin.lab_test.index', compact('labTests'));
    }

    /**
     * Store a newly created lab test.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:lab_tests,name',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        LabTest::create($request->all());

        return response()->json(['success' => true, 'message' => 'Lab Test added successfully!']);
    }

    /**
     * Display the specified lab test.
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified lab test.
     */
    public function edit($id)
    {
        $labTest = LabTest::find($id);
        if (!$labTest) {
            return response()->json(['success' => false, 'message' => 'Lab Test not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $labTest]);
    }

    /**
     * Update the specified lab test.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:lab_tests,name,' . $id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $labTest = LabTest::findOrFail($id);
        $labTest->update($request->all());

        return response()->json(['success' => true, 'message' => 'Lab Test updated successfully!']);
    }

    /**
     * Remove the specified lab test.
     */
    public function destroy($id)
    {
        $labTest = LabTest::find($id);
        if (!$labTest) {
            return response()->json(['success' => false, 'message' => 'Lab Test not found'], 404);
        }
        $labTest->delete();
        return response()->json(['success' => true, 'message' => 'Lab Test deleted successfully!']);
    }
}
