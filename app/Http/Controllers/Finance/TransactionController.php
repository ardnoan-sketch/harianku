<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Transaction::where('user_id', auth()->id())->with('category');

        // Filter Type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter Date Range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        // Search description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->orderBy('date', 'desc')->paginate(5)->withQueryString();
        $categories = \App\Models\Category::where('user_id', auth()->id())->get();

        return view('finance.transactions.index', compact('transactions', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::where('user_id', auth()->id())->get();
        return view('finance.transactions.form', compact('categories'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:ar_categories,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
        ]);

        // Cek kepemilikan kategori
        $category = \App\Models\Category::find($validated['category_id']);
        if ($category->user_id !== auth()->id()) abort(403);
        if ($category->type !== $validated['type']) {
            return back()->withInput()->with('error', 'Tipe kategori tidak sesuai dengan tipe transaksi.');
        }

        $validated['user_id'] = auth()->id();
        \App\Models\Transaction::create($validated);

        return redirect()->route('finance.transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(\App\Models\Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) abort(403);
        $categories = \App\Models\Category::where('user_id', auth()->id())->get();
        return view('finance.transactions.form', compact('transaction', 'categories'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:ar_categories,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
        ]);

        $category = \App\Models\Category::find($validated['category_id']);
        if ($category->user_id !== auth()->id()) abort(403);
        if ($category->type !== $validated['type']) {
            return back()->withInput()->with('error', 'Tipe kategori tidak sesuai dengan tipe transaksi.');
        }

        $transaction->update($validated);

        return redirect()->route('finance.transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(\App\Models\Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) abort(403);
        $transaction->delete();
        return redirect()->route('finance.transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
