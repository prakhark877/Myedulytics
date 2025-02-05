<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\utilities\helper;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function index()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $quizzes = Quiz::with('category', 'subcategory')->get();
        return view('dashboard.admin.quizzes.index', compact('quizzes','user'));
    }

    public function create()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $categories = Category::with('subcategories')->get();
        return view('dashboard.admin.quizzes.create', compact('categories','user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:quizzes',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'description' => 'nullable|string',  
            'image' => 'required|file|mimes:jpg,png,jpeg|max:2048', // Validate file
        ]);
    
        $data = $request->all();

        // Save file directly to public/quiz_images
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('quiz_images'), $imageName);
            $data['image'] = 'quiz_images/' . $imageName;

            Log::info('File uploaded successfully to: ' . public_path('quiz_images/' . $imageName));
        } else {
            Log::info('No valid file uploaded.');
        }
        $title = helper::slug($request->title);
        $data['slug'] = $title;

        Quiz::create($data);

        return redirect()->route('quizzes.index')->with('success', 'Quiz added successfully.');
    }

    public function edit($id)
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $quiz = Quiz::findOrFail($id);
        $categories = Category::with('subcategories')->get();
        return view('dashboard.admin.quizzes.edit', compact('quiz', 'categories','user'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255|unique:quizzes,title,' . $quiz->id,
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'description' => 'nullable|string'
        ]);
        $data = $request->all();
        // Save file directly to public/quiz_images

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            if ($quiz->image && file_exists(public_path($quiz->image))) {
                unlink(public_path($quiz->image));
            }
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('quiz_images'), $imageName);
            $data['image'] = 'quiz_images/' . $imageName;
            
            Log::info('File uploaded successfully to: ' . public_path('quiz_images/' . $imageName));
        } else{
            $data['image'] = $quiz->image;
        }
        $title = helper::slug($request->title);
        $data['slug'] = $title;

        $quiz->update($data);

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}

