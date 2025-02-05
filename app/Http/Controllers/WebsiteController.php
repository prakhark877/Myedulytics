<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\utilities\helper;
use Illuminate\Support\Facades\Log;

class WebsiteController extends Controller
{
    //
    public function index()
    {
        // Pass data to the view if needed
        $quizzes = Quiz::with('category', 'subcategory')->get();
        return view('website.index', compact('quizzes'));
    }

    public function quizList()
    {
        // Pass data to the view if needed
       $quizzes = Quiz::with('category', 'subcategory')->get();
        return view('website.quiz_list', compact('quizzes'));
    }

    public function continueQuizQuestions($slug)
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        // Pass data to the view if needed
        $quizzes = Quiz::where('slug', $slug)->first();
        $random_questions_count = $quizzes->random_questions_count;
        // Get random questions
        $questions = Question::where('quiz_id', $quizzes->id)
        ->inRandomOrder()
        ->take($random_questions_count)
        ->get();
      // return $questions;
        return view('website.continue_quiz_questions', compact('quizzes','questions','user'));
    }
    

    
}
