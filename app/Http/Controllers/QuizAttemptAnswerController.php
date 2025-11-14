<?php

namespace App\Http\Controllers;

use App\Models\QuizAttemptAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Quiz;
use App\Models\Question;
use App\utilities\helper;

class QuizAttemptAnswerController extends Controller
{
    // ✅ Store a new quiz attempt
    public function quizesAttemptAnswer(Request $request)
    {
        $rules = [
            'quiz_id' => 'required',
            'total_attempt_question' => 'required',
            'total_correct_answer' => 'required',
            'user_id' => 'required|integer',
            'answer' => 'required',
        ];

        $messages = [
            'required' => 'The :attribute field is required',
        ];

        $registerValidation = Validator::make($request->all(), $rules, $messages);

        if ($registerValidation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $registerValidation->errors()->first(),
            ]);
        }

        $QuizAttemptAnswer = new QuizAttemptAnswer();
        $QuizAttemptAnswer->quiz_id = $request->quiz_id;
        $QuizAttemptAnswer->total_attempt_question = $request->total_attempt_question;
        $QuizAttemptAnswer->total_correct_answer = $request->total_correct_answer;
        $QuizAttemptAnswer->user_id = $request->user_id;
        $QuizAttemptAnswer->total_questions = $request->total_questions;
        $QuizAttemptAnswer->answer = json_encode($request->answer);
        $QuizAttemptAnswer->save();

        return response()->json([
            'success' => true,
            'message' => 'Attempt answer successfully saved.',
        ]);
    }

    // ✅ Show all quiz attempts (for your attempt_quiz.blade.php)
    public function index()
    {
        // Fetch all quiz attempts (you can later filter by user_id if needed)
        $QuizAttemptAnswer = QuizAttemptAnswer::with('quiz', 'user')->get();

        // Pass data to the view
        return view('dashboard.student.student_attempt_quiz', compact('QuizAttemptAnswer'));
    }
}

//             $messages = [
//                 'required' => 'The :attribute field is required',
//             ];
//             $registerValidation = Validator::make($request->all(), $rules, $messages);
//             if ($registerValidation->fails()) {
//                 $returnArray['success'] = false;
//                 $returnArray['message'] = $registerValidation->errors()->first();
//                 return json_encode($returnArray);
//             }

//             $QuizAttemptAnswer = new QuizAttemptAnswer();
//             $QuizAttemptAnswer->quiz_id = $request->quiz_id;
//             $QuizAttemptAnswer->total_attempt_question = $request->total_attempt_question;
//             $QuizAttemptAnswer->total_correct_answer = $request->total_correct_answer;
//             $QuizAttemptAnswer->user_id = $request->user_id;
//             $QuizAttemptAnswer->total_questions = $request->total_questions;
//             $QuizAttemptAnswer->answer = json_encode($request->answer);
//             $QuizAttemptAnswer->save();

//             $returnArray['success'] = true;
//             $returnArray['message'] = "Attempt ans successfully saved.";
//             return json_encode($returnArray);

// }
