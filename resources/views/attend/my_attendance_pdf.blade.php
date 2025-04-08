<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
</head>
<body>
    <h1>Attendance Report for {{ $user->name }}</h1>
    <p>Month: {{ $month }} Year: {{ $year }}</p>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('Y-m-d') }}</td>
                    <td>{{ $attendance->start_time }}</td>
                    <td>{{ $attendance->end_time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>