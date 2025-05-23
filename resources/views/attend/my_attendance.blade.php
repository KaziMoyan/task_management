@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>My Attendance History</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('attendance.filter') }}">
        <label>Month:</label>
        <input type="number" name="month" min="1" max="12">

        <label>Year:</label>
        <input type="number" name="year" min="2020" max="2099">

        <label>Status:</label>
        <select name="status">
            <option value="">-- All --</option>
            <option value="present">Present</option>
            <option value="leave">Leave</option>
            <option value="absent">Absent</option>
        </select>

        <button type="submit">Filter</button>
    </form>

    <!-- Filter by Month and Year -->
    <form method="POST" action="{{ route('attendance.my') }}" class="row g-3">
        @csrf
        <div class="col-md-2">
            <label>Month</label>
            <input type="number" name="month" class="form-control" min="1" max="12" value="{{ $month }}">
        </div>
        <div class="col-md-2">
            <label>Year</label>
            <input type="number" name="year" class="form-control" value="{{ $year }}">
        </div>
        <div class="col-md-3 align-self-end">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Export Button -->
    <form method="POST" action="{{ route('attendance.my.export') }}" class="mt-3">
        @csrf
        <input type="hidden" name="month" value="{{ $month }}">
        <input type="hidden" name="year" value="{{ $year }}">
        <button type="submit" class="btn btn-danger">
            Export PDF
        </button>
    </form>

    <div class="mt-4">
        <p><strong>Days Present:</strong> <span class="text-success">{{ $daysPresent }}</span></p>
        <p><strong>Days Absent:</strong> <span class="text-danger">{{ $daysAbsent }}</span></p>
        <p><strong>Total Working Hours Today:</strong> <span class="text-primary">{{ $totalWorkingHoursToday }} hours</span></p> <!-- Display total working hours -->
    </div>

    <!-- Attendance Table -->
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Working Hours</th> <!-- Added this column for working hours -->
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $att)
            <tr>
                <td>{{ $att->date }}</td>
                <td>{{ $att->start_time ?? '—' }}</td>
                <td>{{ $att->end_time ?? '—' }}</td>
                <td>{{ $att->start_time && $att->end_time ? Carbon::parse($att->start_time)->diffInHours(Carbon::parse($att->end_time)) . ' hours' : '—' }}</td> <!-- Display working hours for each record -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
