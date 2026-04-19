<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::where('user_id', auth()->id())->latest()->paginate(5);
        return view('finance.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('finance.categories.form');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        $validated['user_id'] = auth()->id();
        \App\Models\Category::create($validated);

        return redirect()->route('finance.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(\App\Models\Category $category)
    {
        if ($category->user_id !== auth()->id()) abort(403);
        return view('finance.categories.form', compact('category'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Category $category)
    {
        if ($category->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        $category->update($validated);

        return redirect()->route('finance.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(\App\Models\Category $category)
    {
        if ($category->user_id !== auth()->id()) abort(403);

        // Cek apakah ada transaksi menggunakan kategori ini
        if ($category->transactions()->exists()) {
            return redirect()->route('finance.categories.index')->with('error', 'Tidak dapat menghapus kategori karena sedang digunakan pada transaksi.');
        }

        $category->delete();
        return redirect()->route('finance.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
