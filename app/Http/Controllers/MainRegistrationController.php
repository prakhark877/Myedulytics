<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainRegistration;

class MainRegistrationController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:registration,email',
            'dob' => 'required|date',
            'password' => 'required|max:255',
            'confirm_password' => 'required|same:password',
        ]);

        MainRegistration::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'dob' => $request->dob,
            'password' => bcrypt($request->password),
            'confirm_password' => bcrypt($request->confirm_password),
        ]);
        return redirect()->route('website.login')->with('success','Registration successful!');
    }
}
