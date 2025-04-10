<?php

namespace App\Http\Controllers;

use App\Models\Marksheet;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\AgeGroups;
use Illuminate\Http\Request;
use App\utilities\helper;

class MarksheetController extends Controller
{
    public function index()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }

        $marksheets = Marksheet::all();
        return view('dashboard.student.marksheets.index', compact('marksheets', 'user'));
    }

    public function create()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }

        $categories = Category::with('subcategories')->get();
        $age_groups = AgeGroups::all();

        return view('dashboard.student.marksheets.create', compact('categories', 'user', 'age_groups'));
    }

    public function store(Request $request)
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $request->validate([
            'description' => 'required',
            'image' => 'nullable|image',
        ]);

        Marksheet::create([
            'description' => $request->description,
            'image' => $request->image,
            'user_id' => $user->id, // assuming user is authenticated
        ]);

        return redirect()->route('marksheets.index')->with('success', 'Marksheet added successfully.');
    }

    public function show($id)
    {
        $user = helper::getTokenInfo();
        $marksheet = Marksheet::findOrFail($id);

        return view('dashboard.student.marksheets.show', compact('marksheet', 'user'));
    }

    public function destroy($id)
    {
        $marksheet = Marksheet::findOrFail($id);
        $marksheet->delete();

        return redirect()->route('marksheets.index')->with('success', 'Marksheet deleted successfully.');
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }
}
