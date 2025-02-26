<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('admin.items.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|string',
            'receipt_no' => 'required|string|unique:items,receipt_no',
        ]);

        $item = Item::create($request->all());

        return response()->json(['success' => true, 'message' => 'Item added successfully.', 'item' => $item]);
    }

    public function show(Item $item)
    {
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|string',
            'receipt_no' => 'required|string|unique:items,receipt_no,'.$item->id,
        ]);

        $item->update($request->all());

        return response()->json(['success' => true, 'message' => 'Item updated successfully.', 'item' => $item]);
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully.']);
    }
}
