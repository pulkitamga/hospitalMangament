<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicineName;

class MedicineNameController extends Controller
{
    // List All Medicines
    public function index()
    {
        $medicines = MedicineName::all();
        return view('admin.medicines_name.index', compact('medicines'));
    }

    // Store New Medicine using AJAX
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:medicine_names,name',
            'total' => 'required|integer'
        ]);

        $medicine = MedicineName::create($request->all());
        return response()->json(['success' => true, 'message' => 'Medicine added successfully.', 'medicine' => $medicine]);
    }

    // Get Medicine Details
    public function show(MedicineName $medicineName)
    {
        return response()->json(['success' => true, 'data' => $medicineName]);
    }

    // Update Medicine using AJAX
    public function update(Request $request, MedicineName $medicineName)
    {
        $request->validate([
            'name' => 'required|unique:medicine_names,name,' . $medicineName->id,
            'total' => 'required|integer'
        ]);

        $medicineName->update($request->all());
        return response()->json(['success' => true, 'message' => 'Medicine updated successfully.', 'medicine' => $medicineName]);
    }

    // Delete Medicine using AJAX
    public function destroy(MedicineName $medicineName)
    {
        $medicineName->delete();
        return response()->json(['success' => true, 'message' => 'Medicine deleted successfully.']);
    }
}
