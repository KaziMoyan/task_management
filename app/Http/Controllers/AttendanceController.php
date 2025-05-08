<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class AttendanceController extends Controller
{
    public function toggle()
    {
        $userId = auth()->id();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $userId)
                        ->whereDate('date', $today)
                        ->first();

        if (!$attendance) {
            // Start attendance
            Attendance::create([
                'user_id' => $userId,
                'start_time' => Carbon::now()->format('H:i:s'),
                'date' => $today,
            ]);
        } elseif (!$attendance->end_time) {
            // End attendance
            $attendance->update([
                'end_time' => Carbon::now()->format('H:i:s'),
            ]);
        }

        return redirect()->back();
    }

    public function create()
    {
        return view('attend.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
                                ->where('date', $today)
                                ->first();

        if (!$attendance) {
            // First time: create with start_time
            Attendance::create([
                'user_id' => $user->id,
                'start_time' => now()->format('H:i:s'),
                'date' => $today,
            ]);

            return back()->with('success', 'Attendance started.');
        } elseif (!$attendance->end_time) {
            // Second time: update with end_time
            $attendance->update([
                'end_time' => now()->format('H:i:s')
            ]);

            return back()->with('success', 'Attendance ended.');
        } else {
            return back()->with('info', 'Attendance already completed for today.');
        }
    }

    public function myAttendance(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Get attendance data
        $attendances = Attendance::where('user_id', $user->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();

        // Calculate attendance stats
        $daysPresent = $attendances->filter(fn($a) => $a->start_time && $a->end_time)->count();
        $totalWorkingHoursToday = 0;
        $workingHours = [];

        // Calculate total working hours for the month
        foreach ($attendances as $attendance) {
            if ($attendance->start_time && $attendance->end_time) {
                $start = Carbon::parse($attendance->start_time);
                $end = Carbon::parse($attendance->end_time);
                $workingHour = $start->diffInHours($end);
                $workingHours[] = $workingHour;
                $totalWorkingHoursToday += $workingHour;
            }
        }

        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $daysAbsent = $totalDays - $daysPresent;

        $averageWorkingHours = count($workingHours) > 0 ? array_sum($workingHours) / count($workingHours) : 0;
        $maxWorkingHours = count($workingHours) > 0 ? max($workingHours) : 0;
        $minWorkingHours = count($workingHours) > 0 ? min($workingHours) : 0;

        return view('attend.my_attendance', compact('attendances', 'month', 'year', 'daysPresent', 'daysAbsent', 'totalWorkingHoursToday', 'averageWorkingHours', 'maxWorkingHours', 'minWorkingHours'));
    }

    public function exportMyAttendance(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Fetch attendance for the specified month and year
        $attendances = Attendance::where('user_id', $user->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();

        // Calculate attendance stats
        $workingHours = [];
        $totalWorkingHours = 0;
        foreach ($attendances as $attendance) {
            if ($attendance->start_time && $attendance->end_time) {
                $start = Carbon::parse($attendance->start_time);
                $end = Carbon::parse($attendance->end_time);
                $workingHour = $start->diffInHours($end);
                $workingHours[] = $workingHour;
                $totalWorkingHours += $workingHour;
            }
        }

        $averageWorkingHours = count($workingHours) > 0 ? array_sum($workingHours) / count($workingHours) : 0;
        $maxWorkingHours = count($workingHours) > 0 ? max($workingHours) : 0;
        $minWorkingHours = count($workingHours) > 0 ? min($workingHours) : 0;

        $pdf = PDF::loadView('attend.my_attendance_pdf', [
            'attendances' => $attendances,
            'user' => $user,
            'month' => $month,
            'year' => $year,
            'totalWorkingHours' => $totalWorkingHours,
            'averageWorkingHours' => $averageWorkingHours,
            'maxWorkingHours' => $maxWorkingHours,
            'minWorkingHours' => $minWorkingHours
        ]);

        return $pdf->download('my_attendance_report.pdf');
    }

    public function filterAttendance(Request $request)
    {
        $query = Attendance::query();

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->get();

        $summary = [
            'present' => $attendances->where('status', 'present')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
        ];

        return view('attend.my_attendance_pdf', compact('attendances', 'summary'));
    }
}
