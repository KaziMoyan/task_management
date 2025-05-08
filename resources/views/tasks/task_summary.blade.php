<!DOCTYPE html>
<html>
<head>
    <title>My Task Summary</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #999;
            text-align: left;
        }
        h2 {
            color: #333;
        }
    </style>
</head>
<body>
    <h2>My Task Summary Report</h2>

    <table>
        <tr>
            <th>Total Task</th>
            <td>{{ $totalTasks }}</td>
        </tr>
        <tr>
            <th>Estimated Hour</th>
            <td>{{ number_format($estimatedHours, 2) }} hours</td>
        </tr>
        <tr>
            <th>Completed Task</th>
            <td>{{ $completedTasks }}</td>
        </tr>
        <tr>
            <th>Completed Hour</th>
            <td>{{ number_format($completedHours, 2) }} hours</td>
        </tr>
    </table>
</body>
</html>
