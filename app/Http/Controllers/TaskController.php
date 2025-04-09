<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
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
        $data['users']= User::get();

        return view('tasks.create',$data);
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
            'assign_by_id' => auth()->id(),
           'user_id' => $request->user_id,
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

    public function myTasks(Request $request)
    {
        $query = Task::where('user_id', auth()->id());
    
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        // Set pagination to 3 tasks per page
        $tasks = $query->orderBy('date', 'desc')->paginate(2);  // Changed from 10 to 3
    
        return view('tasks.my_tasks', compact('tasks'));
    }
    


    
    public function updateTask(Request $request, $id)
    {
    $task = Task::findOrFail($id);

    $task->note = $request->input('note');
    $task->status = $request->input('status');
    $task->time_start = $request->input('time_start');
    $task->time_end = $request->input('time_end');

    $task->save();

    return redirect()->back()->with('success', 'Task updated successfully!');
  }
// public function update(Request $request, $id)
// {
//     $task = Task::findOrFail($id);
//     $task->update($request->all());
//     return redirect()->back()->with('success', 'Task updated successfully!');
// }
// public function show($id)
// {
//     $task = Task::findOrFail($id);
//     return response()->json($task);
// }

// TaskController.php
public function show($id)
{
    $task = Task::findOrFail($id);

    // Calculate the time difference
    $startTime = Carbon::parse($task->time_start);
    $endTime = Carbon::parse($task->time_end);
    $duration = $startTime->diff($endTime);

    // Format the duration to display hours, minutes, and seconds
    $totalTime = $duration->format('%h hours %i minutes %s seconds');

    return view('tasks.task_details', compact('task', 'totalTime'));
}


}
