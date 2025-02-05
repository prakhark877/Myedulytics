<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\utilities\helper;

class CategoryController extends Controller
{
    // Display list of categories
    public function index()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $categories = Category::all();
        return view('dashboard.admin.categories.index', compact('categories', 'user'));
    }

    // Show form to create a new category
    public function create()
    {
        $user = helper::getTokenInfo();
        if (!$user && $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        return view('dashboard.admin.categories.create', compact('user'));
    }

    // Store a newly created category in storage
    public function store(Request $request)
    {
        $request->validate([
            'cat_title' => 'required|string|max:255',
        ]);
          
        $catSlug = helper::slug($request->cat_title);
        // Create the category using only the validated and modified data
        Category::create([
            'cat_title' => $request->cat_title,
            'cat_slug'  => $catSlug,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    // Show the form for editing the specified category
    public function edit($id)
    {
        $user = helper::getTokenInfo();
        if (!$user && $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $category = Category::findOrFail($id);
        return view('dashboard.admin.categories.edit', compact('category','user'));
    }

    // Update the specified category in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'cat_title' => 'required|string|max:255',
        ]);
        $catSlug = helper::slug($request->cat_title);
        $category = Category::findOrFail($id);
        $category->update([
            'cat_title' => $request->cat_title,
            'cat_slug'  => $catSlug,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // Remove the specified category from storage
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
