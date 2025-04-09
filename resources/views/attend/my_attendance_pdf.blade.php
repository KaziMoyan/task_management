<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
</head>
<body>
    <h1>Attendance Report for {{ $user->name }}</h1>
    <p>Month: {{ $month }} Year: {{ $year }}</p>

    <!-- Total Working Hours -->
    <p><strong>Total Working Hours:</strong> 
        @php
            $totalWorkingHours = 0;
        @endphp
        @foreach ($attendances as $attendance)
            @if ($attendance->start_time && $attendance->end_time)
                @php
                    $start = \Carbon\Carbon::parse($attendance->start_time);
                    $end = \Carbon\Carbon::parse($attendance->end_time);
                    $totalWorkingHours += $start->diffInHours($end);
                @endphp
            @endif
        @endforeach
        {{ $totalWorkingHours }} hours
    </p>

    <!-- Attendance Table -->
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Working Hours</th> <!-- Added column for working hours -->
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('Y-m-d') }}</td>
                    <td>{{ $attendance->start_time }}</td>
                    <td>{{ $attendance->end_time }}</td>
                    <td>
                        @if ($attendance->start_time && $attendance->end_time)
                            @php
                                $start = \Carbon\Carbon::parse($attendance->start_time);
                                $end = \Carbon\Carbon::parse($attendance->end_time);
                                $workingHours = $start->diffInHours($end);
                            @endphp
                            {{ $workingHours }} hours
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
