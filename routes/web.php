<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeModeController;
use App\Http\Controllers\ThemePreferenceController;
use App\Http\Controllers\ManagementController;
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
        
        // Unified Management (Modules & Menus)
        Route::get('/management', [ManagementController::class, 'index'])->name('management.index');
        
        // Module routes within management
        Route::get('/management/modules/create', [ManagementController::class, 'moduleCreate'])->name('management.modules.create');
        Route::post('/management/modules', [ManagementController::class, 'moduleStore'])->name('management.modules.store');
        Route::get('/management/modules/{module}/edit', [ManagementController::class, 'moduleEdit'])->name('management.modules.edit');
        Route::put('/management/modules/{module}', [ManagementController::class, 'moduleUpdate'])->name('management.modules.update');
        Route::delete('/management/modules/{module}', [ManagementController::class, 'moduleDestroy'])->name('management.modules.destroy');
        
        // Menu routes within management
        Route::get('/management/menus/create', [ManagementController::class, 'menuCreate'])->name('management.menus.create');
        Route::post('/management/menus', [ManagementController::class, 'menuStore'])->name('management.menus.store');
        Route::get('/management/menus/{menu}/edit', [ManagementController::class, 'menuEdit'])->name('management.menus.edit');
        Route::put('/management/menus/{menu}', [ManagementController::class, 'menuUpdate'])->name('management.menus.update');
        Route::delete('/management/menus/{menu}', [ManagementController::class, 'menuDestroy'])->name('management.menus.destroy');
        
        // Role routes within management
        Route::get('/management/roles/create', [ManagementController::class, 'roleCreate'])->name('management.roles.create');
        Route::post('/management/roles', [ManagementController::class, 'roleStore'])->name('management.roles.store');
        Route::get('/management/roles/{role}/edit', [ManagementController::class, 'roleEdit'])->name('management.roles.edit');
        Route::put('/management/roles/{role}', [ManagementController::class, 'roleUpdate'])->name('management.roles.update');
        Route::delete('/management/roles/{role}', [ManagementController::class, 'roleDestroy'])->name('management.roles.destroy');
        
        // Keep old routes but redirect to new ones (for backward compatibility)
        Route::get('/menus', function() { return redirect()->route('admin.management.index', ['tab' => 'menus']); })->name('menus.index');
        Route::get('/modules', function() { return redirect()->route('admin.management.index', ['tab' => 'modules']); })->name('modules.index');

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
    Route::prefix('productivity')->group(function () {
        // My Day
        Route::get('/my-day', [DailyController::class, 'show'])->name('productivity.myday');
        Route::post('/task/toggle', [DailyController::class, 'toggleTask'])->name('productivity.task.toggle');
        Route::post('/task', [DailyController::class, 'storeTask'])->name('productivity.task.store');

        // Calendar
        Route::get('/calendar', [DailyController::class, 'calendar'])->name('productivity.calendar');

        // Quests
        Route::get('/quests', [QuestController::class, 'index'])->name('productivity.quests.index');
        Route::post('/quests', [QuestController::class, 'store'])->name('productivity.quests.store');
        Route::post('/quests/{quest}/toggle', [QuestController::class, 'toggle'])->name('productivity.quests.toggle');

        // Notes
        Route::resource('notes', NoteController::class);

        // Notebooks
        Route::resource('notebooks', NotebookController::class);
        Route::post('notebooks/{notebook}/items', [NotebookController::class, 'storeItem'])->name('notebooks.items.store');
    });

    Route::patch('/preferences/theme', [ThemePreferenceController::class, 'update'])->name('preferences.theme');

    // User Preferences (Theme per User)
    Route::prefix('user/preferences')->name('user.preferences.')->group(function () {
        Route::patch('/theme', [\App\Http\Controllers\UserPreferenceController::class, 'updateTheme'])->name('theme');
        Route::patch('/accent-color', [\App\Http\Controllers\UserPreferenceController::class, 'updateAccentColor'])->name('accent-color');
    });

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

});

require __DIR__.'/auth.php';
