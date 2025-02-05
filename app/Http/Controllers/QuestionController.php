<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\utilities\helper;
use Illuminate\Http\Request;

class QuestionController extends Controller
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
        return view('dashboard.admin.questions.create', compact('quizzes', 'user'));
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
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'type' => 'required|in:radio,checkbox',
            'options' => 'required|array|min:2|max:4', // Ensure at least two options
            'options.*' => 'required|string', // Each option is required
            'correct_option' => 'required|array', // Ensure correct_option is an array
            'correct_option.*' => 'required|integer|between:0,3', // Correct option indexes must be valid
        ]);

// Map correct_option indexes to their respective option values
        $correctOptions = collect($validated['correct_option'])
            ->map(fn($index) => $validated['options'][$index])
            ->toArray();

// Create a new Question instance
        $question = new Question();
        $question->quiz_id = $validated['quiz_id'];
        $question->question = $validated['question'];
        $question->type = $validated['type'];
        $question->options = json_encode(array_values($validated['options'])); // Save options as JSON
        $question->correct_options = json_encode($correctOptions); // Save correct options as JSON
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
        $questions = Question::join('quizzes', 'quizzes.id', '=', 'questions.quiz_id')
        ->select('questions.*','quizzes.title')->get();
         // Retrieve all questions from the database
        return view('dashboard.admin.questions.index', compact('questions', 'user')); // Return the Blade view with the questions data
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
        $questions = Question::findOrFail($id);
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
    public function update(Request $request, Question $question)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'type' => 'required|in:radio,checkbox',
            'options' => 'required|array|min:1',
            'options.*' => 'required|string|max:255', // Ensure each option is a valid string
            'correct_option' => 'required|array|min:1', // Correct options must be an array
        ]);

// Ensure correct options are valid based on the provided options
        $options = $validated['options']; // Array of options from the form
        $correctOptions = array_intersect($validated['correct_option'], $options); // Keep only valid correct options

// Update the question data
        $question->question = $validated['question'];
        $question->type = $validated['type'];
        $question->options = json_encode($options); // Save options as JSON array
        $question->correct_options = json_encode(array_values($correctOptions)); // Save correct options as JSON array

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
    public function destroy(Question $question)
    {
        $question->delete(); // Delete the question from the database

        // Redirect the user back to the question list with a success message
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully!');
    }
}
