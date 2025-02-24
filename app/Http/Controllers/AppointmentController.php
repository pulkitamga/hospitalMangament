<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])->get();
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('admin.appointments.index', compact('appointments', 'patients', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:scheduled,completed,cancelled',
            'description' => 'nullable|string',
        ]);

        Appointment::create($request->all());

        return response()->json(['success' => true, 'message' => 'Appointment added successfully!']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        return response()->json(['success' => true, 'data' => $appointment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:scheduled,completed,cancelled',
            'description' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return response()->json(['success' => true, 'message' => 'Appointment updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Appointment deleted successfully!']);
    }
}
