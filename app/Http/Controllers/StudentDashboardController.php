<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz; // ✅ make sure you have this model

class StudentDashboardController extends Controller
{
    public function studentFilterQuizList()
    {
        // ✅ Fetch all quizzes (you can later filter by student age or class)
        $quizzes = Quiz::all();

        // ✅ Pass it to the Blade view
        return view('dashboard.student.student_filter_quiz_list', compact('quizzes'));
    }
}
