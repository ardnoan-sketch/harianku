<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Optimize: Aggregate directly in DB
        $totalIncome = $user->transactions()->where('type', 'income')->sum('amount');
        $totalExpense = $user->transactions()->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Chart Data: Last 6 months Income vs Expense
        $chartData = \Illuminate\Support\Facades\DB::table('ar_transactions')
            ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month, type, SUM(amount) as total')
            ->where('user_id', $user->id)
            ->where('date', '>=', now()->subMonths(6))
            ->groupBy('month', 'type')
            ->orderBy('month')
            ->get();
            
        $labels = $chartData->pluck('month')->unique()->values()->all();
        $incomes = [];
        $expenses = [];
        foreach ($labels as $label) {
            $incomes[] = $chartData->where('month', $label)->where('type', 'income')->sum('total');
            $expenses[] = $chartData->where('month', $label)->where('type', 'expense')->sum('total');
        }

        // Only load 5 recent transactions with eager loaded category
        $recentTransactions = $user->transactions()->with('category')->latest('date')->take(5)->get();

        return view('dashboard', compact('totalIncome', 'totalExpense', 'balance', 'recentTransactions', 'labels', 'incomes', 'expenses'));
    }
}
