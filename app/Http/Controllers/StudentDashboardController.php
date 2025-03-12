<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttemptAnswer;
use App\Models\User;
use App\utilities\helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\AgeGroups;
use App\Models\QuizzesAnswer;

class StudentDashboardController extends Controller
{
    //

    public function dashboard(Request $request)
    {
        $user = helper::getTokenInfo();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
            return view('dashboard.student.index')
            ->with('user', $user);
    }

    public function showRegistrationForm()
    {
        return view('website.register-student');
    }

    public function register(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        // If validation fails, return with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the new user
        $user = User::create([
            'student_id' => uniqid(),
            'type'       => 2,
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'name'       => $request->input('first_name') . ' ' . $request->input('last_name'),
            'email'      => $request->input('email'),
            'dob'        => $request->input('dob'),
            'password'   => Hash::make($request->input('password')),
        ]);

        // Log the user in after registration
        // auth()->login($user);

        // Redirect to the dashboard or another route
        return redirect()->route('register')->with('success', 'Registration successful! Please login to continue.');
    }

    public function studentProfile(Request $request)
    {
        $user = helper::getTokenInfo();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        ini_set('max_execution_time', 300);
        $search = $request->search;
        $fromdt = $request->fromdt;
        $todt   = $request->todt;
        $users  = User::where('users.id', $user->id)->select('*');
        $append = [];
        if ($fromdt != '' && $todt != '') {
            $users            = $users->whereBetween('users.created_at', [$fromdt, $todt]);
            $append['fromdt'] = $fromdt;
            $append['todt']   = $todt;
        }

        if ($search != "") {
            $users = $users->orderBy('users.created_at', 'DESC')->where(function ($query) use ($search) {
                $query->where('users.first_name', 'like', '%' . $search . '%')
                // ->orWhere('users.created_at', 'like', '%'.$search.'%')
                    ->orWhere('users.dob', 'like', '%' . $search . '%')
                // ->orWhere('languagepreference', 'like', '%'.$search.'%')
                    ->orWhereRaw("CONCAT('users.first_name', ' ', 'users.last_name') LIKE ?", ['%' . $search . '%']);
            })->paginate(10);
            // $users->appends(['search' => $search]);
            $append['search'] = $search;
        } else {
            $users = $users->orderBy('users.created_at', 'DESC')->paginate(10);
        }

        if (sizeof($append) > 0) {
            // return "appends hai";
            $users = $users->appends($append);
        }

        //$users = UserModel::get();
        // return $users;

        foreach ($users as $ukey => $uvalue) {
            if ($uvalue->Experience != '' && $uvalue->Experience != 0) {
                $exp = $uvalue->Experience;
                $fm  = fmod($exp, 12);
                $yr  = ($exp - $fm) / 12;
                if ($fm == 0) {
                    $nexp = $yr . " yr(s).";
                } elseif ($fm != 0 && $yr == 0) {
                    $nexp = $fm . " month(s)";
                } else {
                    $nexp = $yr . " yr(s). " . $fm . " month(s)";
                }

                $users[$ukey]['Experience'] = $nexp;
            }

        }
        // return $users;
        return view("dashboard.student.student_list", ['users' => $users, 'todt' => $todt, 'fromdt' => $fromdt, 'search' => $search]);
    }

    public function userAttemptQuizAnswerList()
    {
        $user = helper::getTokenInfo();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
    
        $QuizAttemptAnswer = QuizAttemptAnswer::from('quiz_attempt_answer')
        ->where('quiz_attempt_answer.user_id', $user->id)
        ->join('quizzes_answer', 'quizzes_answer.id', '=', 'quiz_attempt_answer.quizzes_answer_id')
        ->join('quizzes', 'quizzes.id', '=', 'quizzes_answer.quiz_id')
        ->join('users', 'users.id', '=', 'quiz_attempt_answer.user_id') // Join users table
        ->select(
            'quizzes_answer.*', 
            'quizzes.title', 
            'users.first_name', 
            'users.last_name'
        )
        ->get();
        return view('dashboard.student.student_attempt_quiz', compact('QuizAttemptAnswer', 'user'));
    }

    public function studentFilterQuizList()
    {
        $user = helper::getTokenInfo();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $age = Carbon::parse($user->dob)->age;
        // Get AGE_GROUP from constants
        $ageGroups = AgeGroups::all(); // Fetch all age groups from the database

        // Get Matching Age Groups (IDs & Names)
        $matchingGroups = $ageGroups->filter(function ($group) use ($age) {
            return $age >= $group->min_age && $age <= $group->max_age;
        });
        
        // Extract IDs and Names
        $matchingGroupIDs = $matchingGroups->pluck('id')->toArray();
        $matchingGroupNames = $matchingGroups->pluck('name')->toArray();
        
        // Get Filtered Quizzes
        $quizzes = Quiz::select('quizzes.*', 'age_groups.name as age_group_name')
        ->join('age_groups', 'quizzes.age_group_id', '=', 'age_groups.id')
        ->whereIn('quizzes.age_group_id', $matchingGroupIDs)
        ->with(['category', 'subcategory']) // Load related category & subcategory
        ->get();
        
        return view('dashboard.student.student_filter_quiz_list', compact('quizzes', 'user','age'));
    }

    

}
