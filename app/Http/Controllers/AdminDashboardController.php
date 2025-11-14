<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminDashboardController extends Controller
{
    // ✅ Admin Dashboard main page
    public function index()
    {
        return view('dashboard.admin.index');
    }

    // ✅ Student List page (fix for Undefined variable $users)
    public function studentList(Request $request)
    {
        // Fetch only student users (type = 2)
        $users = User::where('type', 2)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        // Pass $users to the view
        return view('dashboard.admin.student_list', compact('users'));
    }
}
