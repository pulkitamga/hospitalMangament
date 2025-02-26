<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('status',1)->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $role = Role::create(['name' => $request->name]);
        return response()->json(['message' => 'Role added successfully!', 'role' => $role]);
    }


    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $role=Role::findOrFail($id);
        $role->update(['name'=> $request->name]);
        return response()->json(['message' => 'Role updated successfully!']);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
    if ($role->status == 0) {
        return response()->json([
            'message' => 'Role already deleted!',
            'status' => 'error'
        ]);
    }

    $role->status = 0; // Soft delete
    $role->save();

    return response()->json([
        'message' => 'Role deleted successfully!',
        'status' => 'success'
    ]);
    }

}


