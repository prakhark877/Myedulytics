<?php

namespace App\Http\Controllers;

use App\Models\QuizzesAnswer;
use App\Models\Quiz;
use App\utilities\helper;
use Illuminate\Http\Request;

class QuizzesAnswerController extends Controller
{
    /**
     * Show the form for creating a new question.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $quizzes = Quiz::with('category', 'subcategory')->get();
        return view('dashboard.admin.quizzes_answer.create', compact('quizzes', 'user'));
    }

    /**
     * Store a newly created question in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'quiz_id' => 'required',
            'question' => 'required',
            'type' => 'required'
        ]);
        $options = json_decode($request->options_json, true);
       // Create a new Question instance
        $question = new QuizzesAnswer();
        $question->quiz_id = $validated['quiz_id'];
        $question->question = $validated['question'];
        $question->type = $validated['type'];
        $question->options = json_encode($options); // Save options as JSON
        $question->save(); // Save the question to the database

        // Redirect the user back to the question list or any desired route
        return redirect()->route('questions.index')->with('success', 'Question added successfully!');
    }

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
         // Retrieve all questions from the database
        return view('dashboard.admin.quizzes_answer.index', compact('quizzes_answer', 'user')); // Return the Blade view with the questions data
    }

    /**
     * Show the form for editing the specified question.
     *
     * @param \App\Models\Question $question
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $quizzes = Quiz::with('category', 'subcategory')->get();
        $questions = QuizzesAnswer::findOrFail($id);
        // return $questions;
        return view('dashboard.admin.questions.edit', compact('questions', 'quizzes', 'user'));

    }

    /**
     * Update the specified question in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, QuizzesAnswer $question)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'quiz_id' => 'required',
            'question' => 'required',
            'type' => 'required'
        ]);


        $options = json_decode($request->options_json, true);
        $question->quiz_id = $validated['quiz_id'];
        $question->question = $validated['question'];
        $question->type = $validated['type'];
        $question->options = json_encode($options); // Save options as JSON array
        $question->save();

        // Redirect the user back to the question list or any desired route
        return redirect()->route('questions.index')->with('success', 'Question updated successfully!');
    }

    /**
     * Remove the specified question from the database.
     *
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(QuizzesAnswer $question)
    {
        $question->delete(); // Delete the question from the database

        // Redirect the user back to the question list with a success message
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully!');
    }
}
