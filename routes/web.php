    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\WebsiteController;
    use App\Http\Controllers\StudentDashboardController;
    use App\Http\Controllers\AdminDashboardController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\SubcategoryController;
    use App\Http\Controllers\QuizController;
    use App\Http\Controllers\QuestionController;
    use App\Http\Controllers\QuizAttemptAnswerController;
    use App\Http\Controllers\CmsPagesController;
    use App\Http\Controllers\AgeGroupsController;
    use App\Http\Controllers\QuizzesAnswerController;
    use App\Http\Controllers\MarksheetController;
    use App\Http\Controllers\MainRegistrationController;
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\RegisterController;
    use App\Http\Controllers\StudentLoginController;

Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/studentportal',function(){
    return view('dashboard.student.student_portal');
});

// Route::get("attemptquiz",function (){
//     return view('dashboard.admin.attempt_quiz');
// })->name('attemptquiz');

Route::get("adminindex",function(){
    return view('dashboard.admin.index');
})->name('adminindex');

Route::get("/student_list",function(){
    return view('dashboard.admin.student_list');
})->name('student_list');

Route::get("/studentcertificates",function(){
    return view('dashboard.student.student_certificates');
})->name('studentcertificates');

Route::get("/studentdashboard",function(){
    return view('dashboard.student.student_dashboard');
})->name('studentdashboard');

Route::get("/studentfeedback",function(){
    return view('dashboard.student.student_feedback');
})->name('studentfeedback');

Route::get("/studentassessments",function(){
    return view('dashboard.student.student_assessments');
})->name('studentassessments');

Route::get("/studentquestions",function(){
    return view('dashboard.student.student_questions');
})->name('studentquestions');

Route::get("/studentprofile",function(){
    return view('dashboard.student.student_profile');
})->name('studentprofile');

Route::get('/studentattemptquiz', [QuizAttemptAnswerController::class, 'index'])
    ->name('studentattemptquiz');

Route::post('/studentattemptquiz', [QuizAttemptAnswerController::class, 'quizesAttemptAnswer'])
    ->name('studentattemptquiz.post');

Route::get("/studentfilterquiz",function(){
    return view('dashboard.student.student_filter_quiz_list');
})->name('studentfilterquiz');

Route::get("/studentlist",function(){
    return view('dashboard.student.student_list');
})->name('studentlist');

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "web" middleware group. Make something great!
    |
    */

  Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

  Route::post('/login', [LoginController::class, 'store'])->name('login.store');

  Route::get('/studentportal', function () {
    return view('dashboard.student.student_portal');
 })->name('studentportal');

    // Route::get('/login', function () {
    //     return view('website.login');
    // })->name('login.form');

    // Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])->name('register.create');

    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/studentportal', function () {
        return view('dashboard.student.student_portal');
    })->name('studentportal');
    
    Route::get('/parentlogin',function(){
        return view('website.parentlogin');
    })->name('parentlogin');

    Route::get('/attemptquiz',function(){
        return view('dashboard.student.student_attempt_quiz');
    })->name('attemptquiz');

    Route::get('/teacherlogin',function(){
        return view('website.teacherlogin');
    })->name('teacherlogin');

    // Route::get('/login', function(){
    //     return view('website.login');
    // })->name('login');
    
    Route::get('/dashboard',function() {
        return view('website.dashboard');
    })->name('dashboard');

    Route::get('/assessment',function() {
        return view('website.assessment');
    })->name('assessment');

    Route::get('/admissions',function() {
        return view('website.admissions');
    })->name('admissions');

    Route::get('/mentoring',function() {
        return view('website.mentoring');
    })->name('mentoring');

    // Route::get('/login',function(){
    //     return view('website.login');
    // })->name('login.form');

    Route::post('login',[LoginController::class,'store'])->name('login.store');

    Route::get('/registered', function () {
        return view('website.registerstudent');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    // Show quiz attempts page
    // Route::get('/attemptquiz', [QuizAttemptAnswerController::class, 'index'])->name('attemptquiz');
    //  Route::post('attemptquiz', [QuizAttemptAnswerController::class, 'quizesAttemptAnswer'])->name('attemptquiz');


    Route::post('registered',[MainRegistrationController::class,'store'])->name('registered.store');

    Route::get('/home', [WebsiteController::class, 'index'])->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    // Route::view('/login', 'website.login')->name('login');
    // Route::post('/login', [AuthController::class, 'login'])->name('api.login');

    Route::get('/', function () {
        return view('website/index');
    });

    Route::get('/student/dashboard', [StudentDashboardController::class, 'dashboard'])
     ->name('student.dashboard');

     Route::get('/student/login', [StudentLoginController::class, 'showLoginForm'])->name('student.login');

     Route::post('/student/login', [StudentLoginController::class, 'login'])->name('student.login.submit');

     // Route::get('/dashboard', [StudentDashboardController::class, 'dashboard']);
    // Route::get('/dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard');
    // Route::get('/student-profile', [StudentDashboardController::class, 'studentProfile'])->name('studentProfile');
    // Route::get('/studentportal', [StudentPortalController::class, 'studentPortal'])->name('studentportal');

    // Route::get('/student/attempt-quiz', [StudentDashboardController::class, 'userAttemptQuizAnswerList'])
    // ->name('student.attempt.quiz');
    // Route::get('/student-attempt-quiz', [StudentDashboardController::class, 'userAttemptQuizAnswerList'])
    // ->name('student.attempt.quiz'); // or the name you use in links

    Route::get('/student-filter-quiz', [StudentDashboardController::class, 'studentFilterQuizList'])
    ->name('student.filter.quiz.list');

    Route::get('student-register', [StudentDashboardController::class, 'showRegistrationForm'])->name('register.form');

    Route::post('student-register', [StudentDashboardController::class, 'register'])->name('register');// 
   
    // Route::get('student-attempt-quiz', [StudentDashboardController::class, 'studentFilterQuizList'])->name('studentFilterQuizList');

    Route::get('student-filter-quiz', [StudentDashboardController::class, 'studentFilterQuizList'])->name('studentFilterQuizList');

    Route::post('/get-subcategories', [QuizController::class, 'getSubcategories'])->name('get.subcategories');

    /* Admin Dashboard Get Route */
    Route::get('/s3/token', [AdminDashboardController::class, 'getS3Token']);

    Route::get('/admin-dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('adminDashboard');

    // Route::group(['prefix' => 'super-admin'], function () {
    Route::get('/studentlist', [AdminDashboardController::class, 'studentList'])->name('admin.studentlist');    

    Route::resource('categories', CategoryController::class);

    Route::resource('subcategories', SubcategoryController::class);  

    Route::resource('quizzes', QuizController::class);      

    Route::resource('questions', QuestionController::class);

    Route::resource('quizzes-answer', QuizzesAnswerController::class);

    Route::resource('cms_pages', CmsPagesController::class);

    Route::resource('age-groups', AgeGroupsController::class);

    Route::resource('marksheets', MarksheetController::class);


    // Route::get('attempt-quiz', [AdminDashboardController::class, 'attemptQuizList'])->name('attemptQuizList');
    // });
  
    // Route::get('/marksheet',function() {
    //     return view('dashboard.student.marksheets.create');
    // })->name('marksheet');
  
    Route::get('/get-quiz-answer', [QuizController::class, 'getQuizAnswer']);

    Route::get('/quiz-list', [WebsiteController::class, 'quizList']);

    Route::get('/continue-quiz/{slug}',  [WebsiteController::class, 'continueQuizQuestions']);