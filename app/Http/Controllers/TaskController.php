<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;


class TaskController extends Controller
{
    
    public function index(Request $request) 
    {
        $query = Task::query();
    
        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('short_description', 'like', '%' . $request->search . '%');
            });
        }
    
        // Group Filter
        if ($request->has('group_id') && $request->group_id != '') {
            $query->where('group_id', $request->group_id);
        }
    
        $tasks = $query->with('group')->paginate(3); // Updated pagination from 1 to 10 (can be changed)
    
        $groups = Group::all(); // Load all groups for the dropdown
    
        return view('tasks.index', compact('tasks', 'groups'));
    }

    
    public function create()
    {
        $data['users']= User::get();
        $data['groups'] = Group::get();

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
            'group_id' => 'required|exists:groups,id',
        ]);

       
        Task::create([
            'assign_by_id' => auth()->id(),
           'user_id' => $request->user_id,
           'group_id' => $request->group_id,
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

        $groups = Group::all(); 
        return view('tasks.edit', compact('task','groups'));
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
    
        // Optional: Apply group filter if selected
        if ($request->has('group_id') && $request->group_id != '') {
            $query->where('group_id', $request->group_id);
        }
    
        // Set pagination to 2 tasks per page
        $tasks = $query->orderBy('date', 'desc')->paginate(2);
    
        // ✅ Get all groups to pass to the view
        $groups = Group::all();
    
        return view('tasks.my_tasks', compact('tasks', 'groups'));
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




public function exportPdf(Request $request)
{
    $userId = auth()->id();  // Get the currently authenticated user ID
    $tasks = Task::where('user_id', $userId)->get(); // Filter tasks by the current user

    $totalEstimateMinutes = 0;
    $totalActualMinutes = 0;
    $totalExtraMinutes = 0;

    foreach ($tasks as $task) {
        // Parse start and end times using Carbon
        $start = Carbon::parse($task->time_start);
        $end = Carbon::parse($task->time_end);

        // Calculate actual time in minutes
        $actualTimeInMinutes = $end->diffInMinutes($start);
        $actualTimeInMinutes = max($actualTimeInMinutes, 0); // prevent negative

        // Calculate extra time only if actual > estimated
        $extraTimeInMinutes = max($actualTimeInMinutes - $task->minutes, 0);

        // Accumulate totals
        $totalEstimateMinutes += $task->minutes;
        $totalActualMinutes += $actualTimeInMinutes;
        $totalExtraMinutes += $extraTimeInMinutes;

        // Attach human-readable versions for Blade view
        $task->actual_time = $this->convertMinutesToHoursAndMinutes($actualTimeInMinutes);
        $task->extra_time = $this->convertMinutesToHoursAndMinutes($extraTimeInMinutes);
    }

    // Final formatted total times
    $totalEstimate = $this->convertMinutesToHoursAndMinutes($totalEstimateMinutes);
    $totalActual = $this->convertMinutesToHoursAndMinutes($totalActualMinutes);
    $totalExtra = $this->convertMinutesToHoursAndMinutes($totalExtraMinutes);

    // Generate PDF view
    $pdf = PDF::loadView('tasks.task_pdf', [
        'tasks' => $tasks,
        'totalEstimate' => $totalEstimate,
        'totalActual' => $totalActual,
        'totalExtra' => $totalExtra,
    ]);

    return $pdf->download('tasks_summary.pdf');
}

// Add this helper method to the same controller
private function convertMinutesToHoursAndMinutes($minutes)
{
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    return "{$hours} hours {$mins} minutes";
}




}
