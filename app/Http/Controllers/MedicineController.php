<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineController extends Controller
{
    // ✅ Show all medicines with pagination
    public function index()
    {
        $medicines = Medicine::latest()->paginate(10);
        return view('admin.medicines.index', compact('medicines'));
    }

    // ✅ Fetch medicine details for editing (AJAX support)
    public function edit($id)
    {
        $medicine = Medicine::find($id);

        if (!$medicine) {
            return response()->json(['success' => false, 'message' => 'Medicine not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $medicine]);
    }


    // ✅ Store new medicine (Form submit or AJAX request)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'category' => 'required|string|max:255',
            'status' => 'required|in:available,out_of_stock',
        ]);

        Medicine::create($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Medicine added successfully!']);
        }
        return redirect()->route('medicines.index')->with('success', 'Medicine added successfully!');
    }

    // ✅ Update medicine details (AJAX support)
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'manufacturer' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'category' => 'required|string|max:255',
            'status' => 'required|in:available,out_of_stock',
        ]);
    
        $medicine->update($validated);
    
        return response()->json([
            'success' => true,
            'message' => 'Medicine updated successfully!',
        ]);
    }
    
    

    // ✅ Delete medicine (AJAX support)
    public function destroy($id)
    {
        $medicine = Medicine::find($id);

        if (!$medicine) {
            return response()->json(['success' => false, 'message' => 'Medicine not found'], 404);
        }

        $medicine->delete();

        return response()->json(['success' => true, 'message' => 'Medicine deleted successfully']);
    }

}
