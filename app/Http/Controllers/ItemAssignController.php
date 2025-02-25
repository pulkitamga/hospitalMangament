<?php

namespace App\Http\Controllers;

use App\Models\ItemAssign;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ItemAssignController extends Controller
{
    public function index()
    {
        $itemAssigns = ItemAssign::with('user', 'item')->get();
        $users = User::all();
        $items = Item::all();
        return view('admin.item_assign.index', compact('itemAssigns', 'users', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:assigned,returned',
        ]);

        $itemAssign = ItemAssign::create($request->all());

        return response()->json(['success' => true, 'message' => 'Item assigned successfully.', 'data' => $itemAssign]);
    }

    public function show(ItemAssign $itemAssign)
    {
        return response()->json(['success' => true, 'data' => $itemAssign]);
    }

    public function update(Request $request, ItemAssign $itemAssign)
{
    if (!$itemAssign) {
        return response()->json(['success' => false, 'message' => 'Item assignment not found.'], 404);
    }

    $request->validate([
        'user_id' => 'required|exists:users,id',
        'item_id' => 'required|exists:items,id',
        'quantity' => 'required|integer|min:1',
        'status' => 'required|in:assigned,returned',
    ]);

    $itemAssign->update($request->all());

    return response()->json(['success' => true, 'message' => 'Item assignment updated successfully.']);
}

    public function destroy(ItemAssign $itemAssign)
    {
        $itemAssign->delete();
        return response()->json(['success' => true, 'message' => 'Item assignment deleted successfully.']);
    }
}
