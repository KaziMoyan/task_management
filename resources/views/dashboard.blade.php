@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

@php
    $today = \Carbon\Carbon::today();
    $attendance = \App\Models\Attendance::where('user_id', auth()->id())->whereDate('date', $today)->first();
    $isStarted = $attendance && $attendance->start_time && !$attendance->end_time;
@endphp

<div class="container-fluid" style="display: flex; min-height: 90vh; margin-top: 40px; gap: 30px; background: linear-gradient(to right, #e0eafc, #cfdef3); padding: 40px; border-radius: 15px;">

    <!-- Sidebar -->
    <div style="
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(8px);
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        width: 270px;
        height: fit-content;
        border: 1px solid rgba(255, 255, 255, 0.3);
    ">
        <h4 style="text-align: center; font-weight: 700; font-size: 22px; color: #343a40; margin-bottom: 30px;">
            <i class="fas fa-bars me-2" style="color: #007bff;"></i> Dashboard
        </h4>
        <div>
            
            <div class="dropdown" style="margin-bottom: 10px;">
                <button onclick="toggleDropdown()" style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    width: 100%;
                    padding: 12px 20px;
                    border-radius: 10px;
                    color: #333;
                    background: linear-gradient(145deg, #ffffff, #f0f0f0);
                    box-shadow: 2px 2px 10px #d1d9e6, -2px -2px 10px #ffffff;
                    cursor: pointer;
                    border: none;
                    font-weight: bold;
                ">
                    <span><i class="fas fa-users me-2" style="margin-right: 10px; color: #007bff;"></i> Group</span>
                    <i class="fas fa-caret-down"></i>
                </button>
            
                <div id="groupDropdown" style="display: none; margin-top: 5px;">
                    <a href="{{ route('groups.create') }}" style="
                        display: block;
                        padding: 10px 20px;
                        color: #333;
                        text-decoration: none;
                        border-radius: 8px;
                        margin-top: 5px;
                        background: #f9f9f9;
                        box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.05);
                    " onmouseover="this.style.background='#e6f0ff'" onmouseout="this.style.background='#f9f9f9'">
                        <i class="fas fa-plus-circle me-2" style="margin-right: 8px; color: #28a745;"></i> Create Group
                    </a>
                    <a href="{{ route('groups.index') }}" style="
                        display: block;
                        padding: 10px 20px;
                        color: #333;
                        text-decoration: none;
                        border-radius: 8px;
                        margin-top: 5px;
                        background: #f9f9f9;
                        box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.05);
                    " onmouseover="this.style.background='#e6f0ff'" onmouseout="this.style.background='#f9f9f9'">
                        <i class="fas fa-eye me-2" style="margin-right: 8px; color: #6f42c1;"></i> View Groups
                    </a>
                </div>
            </div>
            
            <a href="{{ route('tasks.create') }}" style="
                display: flex;
                align-items: center;
                padding: 12px 20px;
                margin-bottom: 10px;
                border-radius: 10px;
                color: #333;
                text-decoration: none;
                background: linear-gradient(145deg, #ffffff, #f0f0f0);
                box-shadow: 2px 2px 10px #d1d9e6, -2px -2px 10px #ffffff;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-plus-circle me-2" style="margin-right: 10px; color: #28a745;"></i> Create Task
            </a>
            <a href="{{ route('tasks.index') }}" style="
                display: flex;
                align-items: center;
                padding: 12px 20px;
                margin-bottom: 10px;
                border-radius: 10px;
                color: #333;
                text-decoration: none;
                background: linear-gradient(145deg, #ffffff, #f0f0f0);
                box-shadow: 2px 2px 10px #d1d9e6, -2px -2px 10px #ffffff;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-list-ul me-2" style="margin-right: 10px; color: #ffc107;"></i> All Tasks
            </a>

            <a href="{{ route('tasks.my') }}" style="
                display: flex;
                align-items: center;
                padding: 12px 20px;
                border-radius: 10px;
                color: #333;
                text-decoration: none;
                background: linear-gradient(145deg, #ffffff, #f0f0f0);
                box-shadow: 2px 2px 10px #d1d9e6, -2px -2px 10px #ffffff;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-user-check me-2" style="margin-right: 10px; color: #17a2b8;"></i> My Created Tasks
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div style="
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 30px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 18px;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    ">

        <!-- Start/End Attendance -->
        <form method="POST" action="{{ route('attendance.toggle') }}" style="margin-bottom: 40px;">
            @csrf
            <button type="submit" style="
                font-size: 1.5rem;
                padding: 18px 36px;
                border-radius: 50px;
                color: #fff;
                border: none;
                cursor: pointer;
                background: {{ $isStarted ? 'linear-gradient(145deg, #ff6a6a, #ff4d4d)' : 'linear-gradient(145deg, #4facfe, #00f2fe)' }};
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
                transition: transform 0.2s ease;
            " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas {{ $isStarted ? 'fa-stop' : 'fa-play' }}"></i>
                {{ $isStarted ? 'End Attendance' : 'Start Attendance' }}
            </button>
        </form>

        <!-- Export Attendance -->
        <form method="POST" action="{{ route('attendance.export') }}">
            @csrf
            <button type="submit" style="
                font-size: 1.5rem;
                padding: 18px 36px;
                border-radius: 50px;
                color: #fff;
                border: none;
                cursor: pointer;
                background: linear-gradient(145deg, #43e97b, #38f9d7);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
                transition: transform 0.2s ease;
            " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-file-export me-1"></i> Export Attendance
            </button>
        </form>

    </div>

</div>
<script>
    function toggleDropdown() {
        var dropdown = document.getElementById("groupDropdown");
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }
</script>

@endsection
