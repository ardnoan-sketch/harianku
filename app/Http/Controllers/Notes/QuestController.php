<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Models\Quest;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    public function index()
    {
        $quests = Quest::where('user_id', auth()->id())->get();
        
        $mainQuests = $quests->where('type', 'main');
        $sideQuests = $quests->where('type', 'side');
        
        // Progress calculation
        $total = $quests->count();
        $completed = $quests->where('is_completed', true)->count();
        $progress = $total > 0 ? round(($completed / $total) * 100) : 0;

        return view('notes.quests', compact('mainQuests', 'sideQuests', 'progress'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:main,side',
            'period' => 'required|in:today,week',
        ]);

        auth()->user()->quests()->create($request->all());

        return back()->with('success', 'Quest berhasil ditambahkan');
    }

    public function toggle(Quest $quest)
    {
        if ($quest->user_id !== auth()->id()) abort(403);
        
        $quest->update([
            'is_completed' => !$quest->is_completed
        ]);

        return response()->json(['success' => true, 'is_completed' => $quest->is_completed]);
    }
}
