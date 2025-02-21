<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // 🔹 Login View Show करने के लिए
    public function showLogin()
    {
        return view('login');
    }

    // 🔹 Register View Show करने के लिए
    public function showRegister()
    {
        return view('register');
    }

    // 🔹 लॉगिन फंक्शनलिटी
    public function login(Request $request)
    {
        // Validate form input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Remember Me ऑप्शन को चेक करें
        $remember = $request->has('remember');

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
    }

    // 🔹 रजिस्ट्रेशन फंक्शनलिटी
    public function register(Request $request)
    {
        // Validate form input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Auto login
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    // 🔹 लॉगआउट फंक्शनलिटी
    public function logout(Request $request)
{
    Auth::logout();

    // सेशन को इनवैलिडेट करें और CSRF टोकन को रीजनरेट करें
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Logged out successfully.');
}

}
