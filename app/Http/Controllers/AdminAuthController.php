<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('Admin/Login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        $adminPassword = config('app.admin_password');

        if (!$adminPassword || !Hash::check($validated['password'], $adminPassword)) {
            return back()->withErrors(['password' => 'Invalid admin password.']);
        }

        session(['admin_logged_in' => true]);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }
}
