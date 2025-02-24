<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabResult;
use App\Models\LabOrder;
use App\Models\LabTest;

class LabResultController extends Controller
{
    public function index()
    {
        $labResults = LabResult::with(['order', 'test'])->get();
        $labOrders = LabOrder::all();
        $labTests = LabTest::all();
    
        return view('admin.lab_results.index', compact('labResults', 'labOrders', 'labTests'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:lab_orders,id',
            'test_id' => 'required|exists:lab_tests,id',
            'result' => 'required|string',
            'status' => 'required|in:pending,completed',
        ]);
    
        LabResult::create($request->all());
    
        return response()->json(['success' => true, 'message' => 'Lab Result added successfully!']);
    }
    
    public function edit($id)
    {
        $labResult = LabResult::with(['order', 'test'])->find($id);
    
        if (!$labResult) {
            return response()->json(['success' => false, 'message' => 'Lab Result not found!'], 404);
        }
    
        return response()->json(['success' => true, 'data' => $labResult]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'order_id' => 'required|exists:lab_orders,id',
            'test_id' => 'required|exists:lab_tests,id',
            'result' => 'required|string',
            'status' => 'required|in:pending,completed',
        ]);
    
        $labResult = LabResult::findOrFail($id);
        $labResult->update($request->all());
    
        return response()->json(['success' => true, 'message' => 'Lab Result updated successfully!']);
    }
    
    public function destroy($id)
    {
        $labResult = LabResult::find($id);
    
        if (!$labResult) {
            return response()->json(['success' => false, 'message' => 'Lab Result not found!'], 404);
        }
    
        $labResult->delete();
    
        return response()->json(['success' => true, 'message' => 'Lab Result deleted successfully!']);
    }
    
}
