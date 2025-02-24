<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\LabOrder;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with(['patient', 'doctor', 'labOrder'])->latest()->get();
        $patients = Patient::all();
        $doctors = Doctor::all();
        $labOrders = LabOrder::all();
        
        return view('admin.visits.index', compact('visits', 'patients', 'doctors', 'labOrders'));
    }


    public function edit(Visit $visit)
    {
        return response()->json(['success' => true, 'data' => $visit]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'disease' => 'required|string',
            'status' => 'required|in:pending,completed',
        ]);

        Visit::create($request->all());

        return response()->json(['success' => true, 'message' => 'Visit added successfully!']);
    }

    public function update(Request $request, Visit $visit)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'disease' => 'required|string',
            'status' => 'required|in:pending,completed',
        ]);

        $visit->update($request->all());

        return response()->json(['success' => true, 'message' => 'Visit updated successfully!']);
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return response()->json(['success' => true, 'message' => 'Visit deleted successfully!']);
    }

}
