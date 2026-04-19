<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $employees = $query->orderBy('name', 'asc')->paginate(5)->withQueryString();

        return view('hrd.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hrd.employees.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:ar_employees,email',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'join_date' => 'required|date',
            'base_salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        Employee::create($validated);

        return redirect()->route('hrd.employees.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Optional
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('hrd.employees.form', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:ar_employees,email,' . $employee->id,
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'join_date' => 'required|date',
            'base_salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        $employee->update($validated);

        return redirect()->route('hrd.employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('hrd.employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
