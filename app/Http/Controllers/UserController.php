<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 🏥 1. सभी यूजर्स की लिस्ट दिखाएं
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // 🏥 2. नया यूजर जोड़ने का फॉर्म दिखाएं
    public function create()
    {
        return view('admin.users.create');
    }

    // 🏥 3. नया यूजर सेव करें
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User added successfully.');
    }

    // 🏥 4. किसी यूजर की डिटेल्स दिखाएं
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // 🏥 5. यूजर को एडिट करने का फॉर्म दिखाएं
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // 🏥 6. यूजर अपडेट करें
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // 🏥 7. यूजर को डिलीट करें
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
