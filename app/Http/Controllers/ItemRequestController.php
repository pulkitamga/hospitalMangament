<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemRequest;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemRequestController extends Controller
{
    // List All Item Requests
    public function index()
    {
        $itemRequests = ItemRequest::with(['user', 'item'])->get();
        $users = User::all();
        $items = Item::all();
        return view('admin.item_requests.index', compact('itemRequests', 'users', 'items'));
    }

    // Store New Item Request using AJAX
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $itemRequest = ItemRequest::create($request->all());

        return response()->json(['success' => true, 'message' => 'Item request created successfully!', 'itemRequest' => $itemRequest]);
    }

    // Get Item Request Details
    public function show(ItemRequest $itemRequest)
    {
        return response()->json(['success' => true, 'data' => $itemRequest]);
    }

    // Update Item Request using AJAX
    public function update(Request $request, ItemRequest $itemRequest)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $itemRequest->update($request->all());

        return response()->json(['success' => true, 'message' => 'Item request updated successfully!', 'itemRequest' => $itemRequest]);
    }

    // Delete Item Request using AJAX
    public function destroy(ItemRequest $itemRequest)
    {
        $itemRequest->delete();
        return response()->json(['success' => true, 'message' => 'Item request deleted successfully!']);
    }
}
