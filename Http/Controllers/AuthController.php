<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\User;
// use Illuminate\Support\Facades\Hash;

// class AuthController extends Controller
// {
//     public function showLoginForm()
//     {
//         return view('auth.login');
//     }

//     public function login(Request $request)
//     {
//         $credentials = $request->only('email', 'password');

//         if (Auth::attempt($credentials)) {
//             return redirect()->route('dashboard');
//         }

//         return back()->withErrors(['email' => 'Invalid credentials']);
//     }

//     public function logout()
//     {
//         Auth::logout();
//         return redirect()->route('login');
//     }

//     // إضافة مستخدم جديد (للـ General Manager فقط)
//     public function addUser(Request $request)
//     {
//         if (Auth::user()->role !== 'general') {
//             abort(403, 'Unauthorized');
//         }

//         $request->validate([
//             'name' => 'required',
//             'email' => 'required|email|unique:users',
//             'password' => 'required|min:6',
//             'role' => 'required|in:general,branch,warehouse',
//         ]);

//         User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'role' => $request->role,
//         ]);

//         return redirect()->route('dashboard')->with('success', 'User added successfully');
//     }
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // عرض صفحة تسجيل الدخول
    public function showLogin() {
        return view('login'); // resources/views/login.blade.php
    }

    // عملية تسجيل الدخول
    public function login(Request $request) {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // مثال للتحكم في الوصول حسب الـ role
            // $user = Auth::user();
            // if($user->role === 'branch') { ... }

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Invalid credentials. Please try again.');
    }

    // عرض الداشبورد
    public function dashboard() {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    }

    // تسجيل الخروج
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
