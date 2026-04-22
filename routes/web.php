<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeModeController;
use App\Http\Controllers\ThemePreferenceController;
use App\Http\Controllers\Notes\DailyController;
use App\Http\Controllers\Notes\NoteController;
use App\Http\Controllers\Notes\QuestController;
use App\Http\Controllers\Notes\NotebookController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated Routes Group
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Portal / Lobby
    Route::get('/portal', [PortalController::class, 'index'])->name('portal');

    // Admin Module (requires 'admin' role)
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        // Menu Management
        Route::resource('menus', \App\Http\Controllers\MenuController::class);

        // Module Management
        Route::resource('modules', \App\Http\Controllers\ModuleController::class);

        // User Management
        Route::resource('users', \App\Http\Controllers\UserController::class);

        Route::resource('theme-modes', ThemeModeController::class)->except(['show']);
    });

    // HRD Module (requires 'hrd' or 'admin' role)
    Route::prefix('hrd')->name('hrd.')->middleware('role:hrd|admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\HrdController::class, 'index'])->name('dashboard');
        Route::resource('employees', \App\Http\Controllers\Hrd\EmployeeController::class);
    });

    // Finance Module (requires 'finance' or 'admin' role)
    Route::prefix('finance')->name('finance.')->middleware('role:finance|admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Categories
        Route::resource('categories', \App\Http\Controllers\Finance\CategoryController::class);

        // Transactions
        Route::resource('transactions', \App\Http\Controllers\Finance\TransactionController::class);

        Route::prefix('export')->name('export.')->group(function () {
            Route::post('/trigger', [ExportController::class, 'trigger'])->name('trigger');
            Route::get('/download/{filename}', [ExportController::class, 'download'])->name('download');
        });
    });

    // Productivity Module
    Route::prefix('productivity')->name('notes.')->group(function () {
        // My Day
        Route::get('/my-day', [DailyController::class, 'show'])->name('myday');
        Route::post('/task/toggle', [DailyController::class, 'toggleTask'])->name('task.toggle');
        Route::post('/task', [DailyController::class, 'storeTask'])->name('task.store');

        // Calendar
        Route::get('/calendar', [DailyController::class, 'calendar'])->name('calendar');

        // Quests
        Route::get('/quests', [QuestController::class, 'index'])->name('quests.index');
        Route::post('/quests', [QuestController::class, 'store'])->name('quests.store');
        Route::post('/quests/{quest}/toggle', [QuestController::class, 'toggle'])->name('quests.toggle');

        // Notes
        Route::resource('notes', NoteController::class);

        // Notebooks
        Route::resource('notebooks', NotebookController::class);
        Route::post('notebooks/{notebook}/items', [NotebookController::class, 'storeItem'])->name('notebooks.items.store');
    });

    Route::patch('/preferences/theme', [ThemePreferenceController::class, 'update'])->name('preferences.theme');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

});

require __DIR__.'/auth.php';
