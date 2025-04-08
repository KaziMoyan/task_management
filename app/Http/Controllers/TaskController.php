<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    
    public function index(Request $request)
    {
    $query = Task::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('short_description', 'like', '%' . $request->search . '%');
    }

    
    $tasks = $query->paginate(1);

    return view('tasks.index', compact('tasks'));
   }

    
    public function create()
    {
        return view('tasks.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
            'link' => 'nullable|url',
            'minutes' => 'required|integer|min:1',
            'date' => 'required|date|after_or_equal:today',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
            'status' => 'required|string',
        ]);

       
        Task::create([
            'assign_by_id' => Auth::id(), 
            'user_id' => Auth::id(), 
            'name' => $request->name,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'note' => $request->note,
            'link' => $request->link,
            'minutes' => $request->minutes,
            'date' => $request->date,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'submit_at' => now(), 
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

   
    public function edit($id)
    {
      
        $task = Task::findOrFail($id);

       
        return view('tasks.edit', compact('task'));
    }

    
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
            'link' => 'nullable|url',
            'minutes' => 'required|integer|min:1',
            'date' => 'required|date|after_or_equal:today',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
            'status' => 'required|string',
        ]);

      
        $task = Task::findOrFail($id);

        $task->update([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'note' => $request->note,
            'link' => $request->link,
            'minutes' => $request->minutes,
            'date' => $request->date,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    
    public function destroy($id)
    {
       
        $task = Task::findOrFail($id);
        $task->delete();

      
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
