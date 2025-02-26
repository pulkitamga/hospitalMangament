<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Patient;

class BillController extends Controller
{
    // ✅ Show all bills with patients
    public function index()
    {
        $bills = Bill::with('patient')->latest()->paginate(10);
        $patients = Patient::all();

        return view('admin.bills.index', compact('bills', 'patients'));
    }

    // ✅ Get Bill for Editing
    public function edit($id)
    {
        $bill = Bill::find($id);

        if (!$bill) {
            return response()->json(['success' => false, 'message' => 'Bill not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $bill]);
    }

    // ✅ Store a new bill
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'status' => 'required|in:paid,unpaid',
        ]);

        Bill::create($request->all());

        return response()->json(['success' => true, 'message' => 'Bill added successfully!']);
    }

    // ✅ Update existing bill
    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'status' => 'required|in:paid,unpaid',
        ]);

        $bill->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Bill updated successfully!',
        ]);
    }

    // ✅ Delete a bill
    public function destroy($id)
    {
        $bill = Bill::find($id);

        if (!$bill) {
            return response()->json(['success' => false, 'message' => 'Bill not found'], 404);
        }

        $bill->delete();

        return response()->json(['success' => true, 'message' => 'Bill deleted successfully']);
    }
}
