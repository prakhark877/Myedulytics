<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\utilities\helper;
use Illuminate\Support\Facades\Log;
use App\Models\AgeGroups;

class QuizController extends Controller
{
    public function index()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        // Get Filtered Quizzes
        $quizzes = Quiz::select('quizzes.*', 'age_groups.name as age_group_name')
        ->leftJoin('age_groups', 'quizzes.age_group_id', '=', 'age_groups.id')
        ->with(['category', 'subcategory']) // Load related category & subcategory
        ->get();
       // return  $quizzes;
        return view('dashboard.admin.quizzes.index', compact('quizzes','user'));
    }

    public function create()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $categories = Category::with('subcategories')->get();
        $age_group = AgeGroups::all();

        return view('dashboard.admin.quizzes.create', compact('categories','user','age_group'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:quizzes',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id'
        ]);
    
        $data = $request->all();

        // // Save file directly to public/quiz_images
        // if ($request->hasFile('image') && $request->file('image')->isValid()) {
        //     $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        //     $request->file('image')->move(public_path('quiz_images'), $imageName);
        //     $data['image'] = 'quiz_images/' . $imageName;

        //     Log::info('File uploaded successfully to: ' . public_path('quiz_images/' . $imageName));
        // } else {
        //     Log::info('No valid file uploaded.');
        // }
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
        $age_group = AgeGroups::all();
       // return $categories;
        return view('dashboard.admin.quizzes.edit', compact('quiz', 'categories','user','age_group'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255|unique:quizzes,title,' . $quiz->id,
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id'
        ]);
        $data = $request->all();
        // Save file directly to public/quiz_images
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
    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }
}

