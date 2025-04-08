@extends('layouts.app') 

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

@section('content')
<div class="container-fluid">
    <div class="row">
        @php
        $today = \Carbon\Carbon::today();
        $attendance = \App\Models\Attendance::where('user_id', auth()->id())->whereDate('date', $today)->first();
        $isStarted = $attendance && $attendance->start_time && !$attendance->end_time;
        $isEnded = $attendance && $attendance->start_time && $attendance->end_time;
        @endphp
    
        <!-- Main Content Area centered in the middle -->
        <div class="col-md-9 d-flex justify-content-center mt-5">
            <!-- Attendance Button -->
            <form method="POST" action="{{ route('attendance.toggle') }}">
                @csrf
                <button type="submit"
                    class="btn btn-lg"
                    style="
                        font-size: 2rem;
                        padding: 20px 40px;
                        border-radius: 12px;
                        background-color: {{ $isStarted ? '#dc3545' : '#007BFF' }};
                        color: white;
                        border: none;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                        transition: background-color 0.3s ease;
                    ">
                    <i class="fas fa-play"></i>
                    {{ $isStarted ? 'End Attendance' : 'Start Attendance' }}
                </button>
            </form>

            <!-- Export Attendance Button -->
            <form method="POST" action="{{ route('attendance.export') }}" style="margin-left: 20px;">
                @csrf
                <button type="submit" class="btn btn-lg btn-success"
                    style="
                        font-size: 1.5rem;
                        padding: 20px 40px;
                        border-radius: 12px;
                        background-color: #28a745;
                        color: white;
                        border: none;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                        transition: background-color 0.3s ease;
                    ">
                    <i class="fas fa-file-export"></i>
                    Export Attendance
                </button>
            </form>
        </div>
        
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar" style="background-color: #f8f9fa; border-right: 2px solid #ddd; padding: 20px;">
                <h4 class="text-center mb-4" style="font-size: 24px; color: #343a40;">
                    <i class="fas fa-tasks" style="color: #007bff;"></i> Dashboard Menu
                </h4>
                <div class="list-group">
                    <a href="{{ route('tasks.create') }}" class="list-group-item list-group-item-action" 
                       style="border: none; background-color: #e9ecef; padding: 12px 20px; font-size: 16px; text-align: left; color: #007bff;">
                       <i class="fas fa-plus-circle" style="color: #28a745;"></i> Create Task
                    </a>
                    <a href="{{ route('tasks.index') }}" class="list-group-item list-group-item-action"
                       style="border: none; background-color: #e9ecef; padding: 12px 20px; font-size: 16px; text-align: left; color: #007bff;">
                       <i class="fas fa-list-ul" style="color: #ffc107;"></i> All Tasks
                    </a>
                </div>
                
            </div>
            
        </div>
        <a href="{{ route('tasks.my') }}" class="list-group-item list-group-item-action"
   style="border: none; background-color: #e9ecef; padding: 12px 20px; font-size: 16px; text-align: left; color: #007bff;">
   <i class="fas fa-user-check" style="color: #17a2b8;"></i> My Created Tasks
</a>


    </div>
</div>
@endsection
