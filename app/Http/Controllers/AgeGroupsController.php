<?php

namespace App\Http\Controllers;

use App\Models\AgeGroups;
use Illuminate\Http\Request;
use App\utilities\helper;

class AgeGroupsController extends Controller
{
    // Display list of categories
    public function index()
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $age_groups = AgeGroups::all();
        return view('dashboard.admin.age_groups.index', compact('age_groups', 'user'));
    }

    // Show form to create a new age_groups
    public function create()
    {
        $user = helper::getTokenInfo();
        if (!$user && $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        return view('dashboard.admin.age_groups.create', compact('user'));
    }

    // Store a newly created age_groups in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'min_age'=> 'required',
            'max_age'=> 'required'
        ]);
      
        AgeGroups::create([
            'name' => $request->name,
            'min_age' => $request->min_age,
            'max_age' => $request->max_age
        ]);

        return redirect()->route('age-groups.index')->with('success', 'Age Group added successfully.');
    }

    // Show the form for editing the specified age_groups
    public function edit($id )
    {
        $user = helper::getTokenInfo();
        if (!$user && $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        
        $age_groups = AgeGroups::findOrFail($id);
        return view('dashboard.admin.age_groups.edit', compact('age_groups','user'));
    }

    // Update the specified age_groups in storage
    public function update(Request $request, $id )
    {
        $request->validate([
            'name' => 'required',
            'min_age'=> 'required',
            'max_age'=> 'required',
        ]);
     
        $age_groups = AgeGroups::findOrFail($id );
        $age_groups->update([
            'name' => $request->name,
            'min_age' => $request->min_age,
            'max_age' => $request->max_age
        ]);

        return redirect()->route('age-groups.index')->with('success', 'Age Groups updated successfully.');
    }

    // Remove the specified category from storage
    public function destroy($id)
    {
        $age_groups = AgeGroups::findOrFail($id);
        $age_groups->delete();

        return redirect()->route('age-groups.index')->with('success', 'Age Groups deleted successfully.');
    }
}
