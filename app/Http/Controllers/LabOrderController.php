<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LabOrder;
use App\Models\Visit;
use App\Models\Patient;
use Illuminate\Http\Request;

class LabOrderController extends Controller
{
    /**
     * Display a listing of the lab orders.
     */ 
    public function index()
    {
        $labOrders = LabOrder::with(['visit', 'patient'])->get();
        $visits = Visit::all();
        $patients = Patient::all();

        return view('admin.lab_orders.index', compact('labOrders', 'visits', 'patients'));
    }

    /**
     * Store a newly created lab order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'patient_id' => 'required|exists:patients,id',
            'status' => 'required|in:pending,completed',
        ]);

        LabOrder::create($request->all());

        return response()->json(['success' => true, 'message' => 'Lab Order added successfully!']);
    }
    public function show($id)
    {
        return $this->edit($id);
    }


    /**
     * Show the form for editing the specified lab order.
     */
    public function edit($id)
    {
        $labOrder = LabOrder::findOrFail($id);
        return response()->json(['success' => true, 'data' => $labOrder]);
    }

    /**
     * Update the specified lab order.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'patient_id' => 'required|exists:patients,id',
            'status' => 'required|in:pending,completed',
        ]);

        $labOrder = LabOrder::findOrFail($id);
        $labOrder->update($request->all());

        return response()->json(['success' => true, 'message' => 'Lab Order updated successfully!']);
    }

    /**
     * Remove the specified lab order.
     */
    public function destroy($id)
    {
        LabOrder::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Lab Order deleted successfully!']);
    }
}
