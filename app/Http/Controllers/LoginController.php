<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('website.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // 1️⃣ Fetch user
        $user = User::where('student_email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'No user found for this email!');
        }

        // 2️⃣ Verify password
        if (!Hash::check($request->password, $user->student_password)) {
            return back()->with('error', 'Wrong password!');
        }

        // 3️⃣ Store session (optional)
        session(['student_email' => $user->student_email]);

        // 4️⃣ Redirect
        return redirect()->route('studentportal')->with('success', 'Login Successful!');
    }
}
