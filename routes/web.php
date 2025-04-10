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
Route::get('/', [WebsiteController::class, 'index']);
Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
Route::view('/login', 'website.login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
// Route::get('/', function () {
//     return view('website/index');
// });
//Route::get('/dashboard', [StudentDashboardController::class, 'dashboard']);
Route::get('/dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/student-profile', [StudentDashboardController::class, 'studentProfile'])->name('studentProfile');


use App\Http\Controllers\Auth\RegisterController;

Route::get('register', [StudentDashboardController::class, 'showRegistrationForm'])->name('register.form');
Route::post('register', [StudentDashboardController::class, 'register'])->name('register');
Route::post('quizesAttemptAnswer', [QuizAttemptAnswerController::class, 'quizesAttemptAnswer'])->name('quizesAttemptAnswer');
Route::get('student-attempt-quiz', [StudentDashboardController::class, 'userAttemptQuizAnswerList'])->name('userAttemptQuizAnswerList');
Route::get('student-filter-quiz', [StudentDashboardController::class, 'studentFilterQuizList'])->name('studentFilterQuizList');
Route::post('/get-subcategories', [QuizController::class, 'getSubcategories'])->name('get.subcategories');





/* Admin Dashboard Get Route */
Route::get('/s3/token', [AdminDashboardController::class, 'getS3Token']);
Route::get('/admin-dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('adminDashboard');

Route::group(['prefix' => 'super-admin'], function () {
    Route::get('/student-list', [AdminDashboardController::class, 'studentList']);
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubcategoryController::class);
    Route::resource('quizzes', QuizController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('quizzes-answer', QuizzesAnswerController::class);
    
    Route::resource('cms_pages', CmsPagesController::class);
    Route::resource('age-groups', AgeGroupsController::class);
    Route::get('attempt-quiz', [AdminDashboardController::class, 'attemptQuizList'])->name('attemptQuizList');
    
});
Route::resource('marksheets', MarksheetController::class);
Route::get('/get-quiz-answer', [QuizController::class, 'getQuizAnswer']);

Route::get('/quiz-list', [WebsiteController::class, 'quizList']);
Route::get('/continue-quiz/{slug}',  [WebsiteController::class, 'continueQuizQuestions']);