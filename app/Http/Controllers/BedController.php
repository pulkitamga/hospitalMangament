<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bed;
use App\Models\Room;
use App\Models\Patient;

class BedController extends Controller
{
    // ✅ Show all beds in one page with form
    public function index()
    {
        $beds = Bed::with(['room', 'patient'])->latest()->paginate(10);
        $rooms = Room::all();
        $patients = Patient::all();

        return view('admin.bed.index', compact('beds', 'rooms', 'patients'));
    }

    public function edit($id)
{
    $bed = Bed::find($id);

    if (!$bed) {
        return response()->json(['success' => false, 'message' => 'Bed not found'], 404);
    }

    return response()->json(['success' => true, 'data' => $bed]);
}


    // ✅ Store new bed (Form submit or AJAX request)
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'patient_id' => 'nullable|exists:patients,id',
            'status' => 'required|in:allotted,available',
            'alloted_time' => 'nullable|date',
            'discharge_time' => 'nullable|date|after:alloted_time',
        ]);

        Bed::create($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Bed added successfully!']);
        }
        return redirect()->route('admin.bed.index')->with('success', 'Bed added successfully!');
        
    }

   // ✅ Update bed details
public function update(Request $request, Bed $bed)
{
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'patient_id' => 'nullable|exists:patients,id',
        'status' => 'required|in:allotted,available',
        'alloted_time' => 'nullable|date',
        'discharge_time' => 'nullable|date|after:alloted_time',
    ]);

    $bed->update($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Bed updated successfully!',
    ]);
}

    // ✅ Delete bed
    public function destroy($id)
{
    $bed = Bed::find($id);

    if (!$bed) {
        return response()->json(['success' => false, 'message' => 'Bed not found'], 404);
    }

    $bed->delete();

    return response()->json(['success' => true, 'message' => 'Bed deleted successfully']);
}

}
