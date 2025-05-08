<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function create()
    {
        return view('groups.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Group::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Group created successfully!');
    }
    public function index(Request $request) 
    {
        $query = Group::with('user')->latest(); // Start query builder with eager loading
    
        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
    
        $groups = $query->paginate(2); // Paginate the filtered or unfiltered results
    
        return view('groups.index', compact('groups'));
    }
    
   public function edit($id)
{
    $group = Group::findOrFail($id);
    return view('groups.edit', compact('group'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $group = Group::findOrFail($id);
    $group->name = $request->name;
    $group->save();

    return redirect()->route('groups.index')
        ->with('success', 'Group updated successfully.');
}

}
