<?php

namespace App\Http\Controllers;

use App\Models\BirthReport;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class BirthReportController extends Controller
{
    public function index()
    {
        $birthReports = BirthReport::with('patient', 'doctor')->latest()->get();
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('admin.birth_reports.index', compact('birthReports', 'patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'description' => 'required|string',
            'gender' => 'required|in:male,female',
        ]);

        BirthReport::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'gender' => $request->gender,
            'description' => $request->description
        ]);

        return response()->json(['message' => 'Birth Report Added Successfully']);
    }

    public function edit($id)
    {
        $birthReport = BirthReport::find($id);
        if (!$birthReport) {
            return response()->json(['message' => 'Birth Report not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $birthReport]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'description' => 'required|string',
            'gender' => 'required|in:male,female',
        ]);

        $birthReport = BirthReport::findOrFail($id);
        $birthReport->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'gender' => $request->gender,
            'description' => $request->description
        ]);

        return response()->json(['message' => 'Birth Report Updated Successfully']);
    }

    public function destroy($id)
    {
        $birthReport = BirthReport::find($id);
        if (!$birthReport) {
            return response()->json(['message' => 'Birth Report not found'], 404);
        }
        $birthReport->delete();
        return response()->json(['message' => 'Birth Report Deleted Successfully']);
    }
}
