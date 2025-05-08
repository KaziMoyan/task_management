<!DOCTYPE html>
<html>
<head>
    <title>My Tasks Summary</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #28a745; color: white; }
        h4 { margin-top: 30px; }
    </style>
</head>
<body>
    <h2>My Task Summary</h2>

    <table>
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <th>Estimated Time (min)</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actual Time</th>
                <th>Extra Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                @php
                    // Calculate Actual Time (difference between start and end time)
                    $start = \Carbon\Carbon::parse($task->time_start);
                    $end = \Carbon\Carbon::parse($task->time_end);
                    $actualTimeInMinutes = $end->diffInMinutes($start);

                    // Ensure Actual Time is never negative
                    $actualTimeInMinutes = max($actualTimeInMinutes, 0);

                    // Calculate Extra Time (Actual Time - Estimated Time, but only if Actual Time > Estimated Time)
                    $extraTimeInMinutes = max($actualTimeInMinutes - $task->minutes, 0);

                    // Convert Actual and Extra Time to hours and minutes
                    $actualTime = convertMinutesToHoursAndMinutes($actualTimeInMinutes);
                    $extraTime = convertMinutesToHoursAndMinutes($extraTimeInMinutes);
                @endphp

                <tr>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->short_description }}</td>
                    <td>{{ $task->minutes }} mins</td>
                    <td>{{ $task->time_start }}</td>
                    <td>{{ $task->time_end }}</td>
                    <td>{{ $actualTime }}</td> <!-- Actual Time -->
                    <td>{{ $extraTime }}</td>  <!-- Extra Time -->
                    <td>{{ ucfirst(str_replace('_', ' ', $task->status)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <h4>Total Estimated Time: {{ $totalEstimate }}</h4>
    <h4>Total Actual Time: {{ $totalActual }}</h4>
    <h4>Total Extra Time: {{ $totalExtra }}</h4>

</body>
</html>

<!-- Helper function to convert minutes to hours and minutes format -->
@php
    function convertMinutesToHoursAndMinutes($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
        return sprintf('%02d hours %02d minutes', $hours, $minutes);
    }
@endphp
