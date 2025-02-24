<?php

namespace App\Http\Controllers;

use App\Models\CmsPages;
use Illuminate\Http\Request;
use App\utilities\helper;

class CmsPagesController extends Controller
{
    // Display list of categories
    public function index()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $cms_pages = CmsPages::all();
        return view('dashboard.admin.cms_pages.index', compact('cms_pages', 'user'));
    }

    // Show form to create a new cms_pages
    public function create()
    {
        $user = helper::getTokenInfo();
        if (!$user && $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        return view('dashboard.admin.cms_pages.create', compact('user'));
    }

    // Store a newly created cms_pages in storage
    public function store(Request $request)
    {
        $request->validate([
            'page_title' => 'required',
            'page_type'=> 'required',
        ]);
          
        $page_slug = helper::slug($request->page_title);
        // Create the cms_pages using only the validated and modified data
        CmsPages::create([
            'page_title' => $request->page_title,
            'page_type' => $request->page_type,
            'short_desc' => $request->short_desc,
            'content' => $request->content,
            'cat_id' => $request->cat_id,
            'pg_bgimg' => $request->pg_bgimg,
            'subcat_id' => $request->subcat_id,
            'page_slug'  => $page_slug,
        ]);

        return redirect()->route('cms_pages.index')->with('success', 'cms content added successfully.');
    }

    // Show the form for editing the specified cms_pages
    public function edit($page_id )
    {
        $user = helper::getTokenInfo();
        if (!$user && $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        
        $cms_pages = CmsPages::findOrFail($page_id);
        return view('dashboard.admin.cms_pages.edit', compact('cms_pages','user'));
    }

    // Update the specified cms_pages in storage
    public function update(Request $request, $page_id )
    {
        $request->validate([
            'page_title' => 'required',
            'page_type'=> 'required',
        ]);
        $page_slug = helper::slug($request->page_title);
        $cms_pages = CmsPages::findOrFail($page_id );
        $cms_pages->update([
            'page_title' => $request->page_title,
            'page_type' => $request->page_type,
            'short_desc' => $request->short_desc,
            'content' => $request->content,
            'cat_id' => $request->cat_id,
            'pg_bgimg' => $request->pg_bgimg,
            'subcat_id' => $request->subcat_id,
            'page_slug'  => $page_slug,
        ]);

        return redirect()->route('cms_pages.index')->with('success', 'cms content updated successfully.');
    }

    // Remove the specified category from storage
    public function destroy($id)
    {
        $cms_pages = CmsPages::findOrFail($id);
        $cms_pages->delete();

        return redirect()->route('cms_pages.index')->with('success', 'cms content deleted successfully.');
    }
}
