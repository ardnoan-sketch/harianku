<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::where('user_id', auth()->id())->latest()->paginate(12);
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:daily_note,general_note',
        ]);

        auth()->user()->notes()->create($request->all());

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dibuat');
    }

    public function edit(Note $note)
    {
        $this->authorizeOwner($note);
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $this->authorizeOwner($note);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:daily_note,general_note',
        ]);

        $note->update($request->all());

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil diperbarui');
    }

    public function destroy(Note $note)
    {
        $this->authorizeOwner($note);
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dihapus');
    }

    private function authorizeOwner(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
