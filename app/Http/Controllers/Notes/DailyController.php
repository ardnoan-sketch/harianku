<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Models\DailyLog;
use App\Models\DailyTask;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DailyController extends Controller
{
    public function show(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $dailyLog = DailyLog::firstOrCreate([
            'user_id' => auth()->id(),
            'date' => $date,
        ]);

        $dailyLog->load('tasks');

        if ($request->ajax()) {
            return response()->json([
                'dailyLog' => $dailyLog,
                'tasks' => $dailyLog->tasks
            ]);
        }

        return view('notes.my_day', compact('dailyLog'));
    }

    public function toggleTask(Request $request)
    {
        $task = DailyTask::whereHas('dailyLog', function($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($request->id);

        $task->update([
            'is_completed' => $request->is_completed
        ]);

        return response()->json(['success' => true]);
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'daily_log_id' => 'required|exists:ar_daily_logs,id',
            'type' => 'required|in:morning,afternoon,evening',
            'title' => 'required|string|max:255',
        ]);

        $dailyLog = DailyLog::where('user_id', auth()->id())->findOrFail($request->daily_log_id);

        $task = $dailyLog->tasks()->create([
            'type' => $request->type,
            'title' => $request->title,
            'is_completed' => false,
        ]);

        return response()->json(['success' => true, 'task' => $task]);
    }

    public function calendar()
    {
        $logs = DailyLog::where('user_id', auth()->id())->get(['date']);
        $activeDates = $logs->pluck('date')->map(fn($d) => $d->format('Y-m-d'))->toArray();
        
        return view('notes.calendar', compact('activeDates'));
    }
}
