<?php

namespace App\Http\Controllers;

use App\Models\QuizzesAnswer;
use App\Models\Quiz;
use App\Models\Question;
use App\utilities\helper;
use Illuminate\Http\Request;

class QuizzesAnswerController extends Controller
{
    

    /**
     * Display a listing of questions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $quizzes_answer = QuizzesAnswer::join('quizzes', 'quizzes.id', '=', 'quizzes_answer.quiz_id')
        ->select('quizzes_answer.*','quizzes.title')->get();

        $quizzes = Quiz::select('quizzes.*', 'age_groups.name as age_group_name')
        ->join('age_groups', 'quizzes.age_group_id', '=', 'age_groups.id')
        ->with(['category', 'subcategory']) // Load related category & subcategory
        ->get();
         // Retrieve all questions from the database
        return view('dashboard.admin.quizzes_answer.index', compact('quizzes_answer','quizzes', 'user')); // Return the Blade view with the questions data
    }

    /**
     * Show the form for editing the specified question.
     *
     * @param \App\Models\Question $question
     * @return \Illuminate\View\View
     */
    public function edit($quiz_id)
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
       
        $quizzes = Quiz::where('id',$quiz_id)->with('category', 'subcategory')->first();
        $quizzes_answer = QuizzesAnswer::where('quiz_id',$quiz_id)->get();
        $questions = Question::where('quiz_id',$quiz_id)->first();
        // return $questions;
        if (!$questions) {
            return redirect()->back()->with('error', 'No questions available for this quiz.');
        }
        return view('dashboard.admin.quizzes_answer.edit', compact('quizzes_answer','questions', 'quizzes', 'user'));
    }

    /**
     * Update the specified question in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'quiz_id' => 'required'
        ]);
        // QuizzesAnswer::where('quiz_id',$validated['quiz_id'])->delete();
        $options_result_json = json_decode($request->options_result_json, true);
        foreach ($options_result_json as $option) {
            QuizzesAnswer::updateOrCreate(
                [
                    'quiz_id' => $validated['quiz_id'],
                    'options_id' => $option['options_id']
                ],
                [
                    'options_result' => $option['options_result'],
                    'options_description' => $option['options_description']
                ]
            );
        }

        // Redirect the user back to the question list or any desired route
        return redirect()->route('quizzes-answer.index')->with('success', 'Save successfully!');
    }

    
}
