<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Models\Notebook;
use App\Models\NotebookItem;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
    public function index()
    {
        $notebooks = Notebook::where('user_id', auth()->id())->withCount('items')->get();
        return view('notes.notebooks.index', compact('notebooks'));
    }

    public function show(Notebook $notebook)
    {
        if ($notebook->user_id !== auth()->id()) abort(403);
        $notebook->load('items');
        return view('notes.notebooks.show', compact('notebook'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        auth()->user()->notebooks()->create($request->all());
        return back()->with('success', 'Notebook berhasil dibuat');
    }

    public function storeItem(Request $request, Notebook $notebook)
    {
        if ($notebook->user_id !== auth()->id()) abort(403);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $notebook->items()->create($request->all());

        return back()->with('success', 'Item berhasil ditambahkan ke notebook');
    }
}
