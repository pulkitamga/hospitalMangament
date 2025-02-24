<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Department;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::with('department')->get();
        $departments = Department::all();
        return view('admin.room.index', compact('rooms', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:available,occupied,maintenance',
            'type' => 'required|in:ward,private,semi-private,general',
        ]);

        if ($request->id) {
            $room = Room::findOrFail($request->id);
            $room->update($request->all());
            return response()->json(['success' => true, 'message' => 'Room updated successfully.']);
        } else {
            Room::create($request->all());
            return response()->json(['success' => true, 'message' => 'Room added successfully.']);
        }
    }

    public function show($id)
{
    $room = Room::findOrFail($id);
    return response()->json(['success' => true, 'data' => $room]);
}

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:available,occupied,maintenance',
            'type' => 'required|in:ward,private,semi-private,general',
        ]);

        $room->update($request->all());
        return response()->json(['success' => true, 'message' => 'Room updated successfully.']);
    }

    public function destroy($id)
{
    $room = Room::findOrFail($id);
    $room->delete();
    return response()->json(['success' => true, 'message' => 'Room deleted successfully.']);
}
}
