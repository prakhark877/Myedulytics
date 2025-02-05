<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\utilities\helper;

class SubcategoryController extends Controller
{
    public function index()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $categories = Category::all();
        $subcategories = Subcategory::with('category')->get();
        return view('dashboard.admin.subcategories.index', compact('categories','subcategories','user'));
    }

    public function create()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $categories = Category::all();
        return view('dashboard.admin.subcategories.create', compact('categories','user'));
    }

    public function store(Request $request)
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcat_title' => 'required|string|max:255|unique:subcategories,subcat_title',
        ]);

        Subcategory::create([
            'category_id' => $request->category_id,
            'subcat_title' => $request->subcat_title,
            'subcat_slug' => helper::slug($request->subcat_title),
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory added successfully.');
    }

    public function edit($id)
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::all();
        return view('dashboard.admin.subcategories.edit', compact('subcategory', 'categories','user'));
    }

    public function update(Request $request, $id)
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $subcategory = Subcategory::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcat_title' => 'required|string|max:255|unique:subcategories,subcat_title,' . $subcategory->id,
        ]);

        $subcategory->update([
            'category_id' => $request->category_id,
            'subcat_title' => $request->subcat_title,
            'subcat_slug' => helper::slug($request->subcat_title),
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();

        return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }
}
