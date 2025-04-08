<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
}
