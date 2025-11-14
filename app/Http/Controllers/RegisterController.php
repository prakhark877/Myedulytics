<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\RegistrationModel;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function create()
    {
        return view('website.registerstudent');
    }

    public function store(Request $request)
    {
        // Validate basic fields
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'smail' => 'required|email|unique:users,student_email',
            'spassword' => 'required|min:6',
        ]);

        try {
            $user = RegistrationModel::create([
                'first_name' => $request->fname,
                'last_name' => $request->lname,
                'preferred_name' => $request->pname,
                'dob' => $request->dob,
                'student_email' => $request->smail,
                'student_password' => Hash::make($request->spassword),
                'parent_email' => $request->pmail,
                'parent_password' => Hash::make($request->ppassword),
                'country' => $request->country,
                'region' => $request->region,
                'preset' => $request->{'school-preset'},
                'curriculum' => $request->curriculum,
                'grade' => $request->grade,
                'languages' => $request->languages,
                'academic' => $request->academic,
                'activities' => $request->activities,
                'studyhours' => $request->study_hours,
                'learningpreferences' => json_encode($request->learningpreferences),
                'consent' => json_encode($request->consent),
            ]);

            // Optional: Trigger verification email
            event(new Registered($user));

            return redirect()->back()->with('success', '✅ Student registered successfully!');
        } catch (\Exception $e) {
            dd('Error inserting data: ', $e->getMessage());
        }
    }
}
