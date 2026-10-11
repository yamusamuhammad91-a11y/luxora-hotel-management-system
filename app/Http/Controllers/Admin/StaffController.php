<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    /**
     * Display the staff directory.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
        ]);

        $staffQuery = Staff::query()
            ->when($validated['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('staff_number', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%");
                });
            })
            ->when($validated['department'] ?? null, function ($query, $department) {
                $query->where('department', $department);
            })
            ->when($validated['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            });

        $staff = $staffQuery
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total' => Staff::count(),
            'active' => Staff::where('status', 'active')->count(),
            'inactive' => Staff::where('status', 'inactive')->count(),
            'departments' => Staff::distinct('department')
                ->count('department'),
        ];

        $departments = Staff::query()
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        return view('admin.staff.index', compact(
            'staff',
            'stats',
            'departments'
        ));
    }

    /**
     * Show the create staff form.
     */
    public function create(): View
    {
        return view('admin.staff.create');
    }

    /**
     * Save a new staff member.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'staff_number' => ['required', 'string', 'max:50', 'unique:staff,staff_number'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:staff,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'department' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:150'],
            'hire_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
            'employment_type' => [
                'required',
                Rule::in(['full_time', 'part_time', 'contract']),
            ],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'address' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $validated['staff_number'] = Str::upper(trim($validated['staff_number']));
        $validated['email'] = Str::lower(trim($validated['email']));

        Staff::create($validated);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff member added successfully.');
    }

    /**
     * Show the edit staff form.
     */
    public function edit(Staff $staff): View
    {
        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update an existing staff member.
     */
    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $validated = $request->validate([
            'staff_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('staff', 'staff_number')->ignore($staff->id),
            ],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('staff', 'email')->ignore($staff->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'department' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:150'],
            'hire_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
            'employment_type' => [
                'required',
                Rule::in(['full_time', 'part_time', 'contract']),
            ],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'address' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $validated['staff_number'] = Str::upper(trim($validated['staff_number']));
        $validated['email'] = Str::lower(trim($validated['email']));

        $staff->update($validated);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff record updated successfully.');
    }

    /**
     * Activate or deactivate a staff member.
     */
    public function toggleStatus(Staff $staff): RedirectResponse
    {
        $staff->update([
            'status' => $staff->status === 'active'
                ? 'inactive'
                : 'active',
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff status updated successfully.');
    }

    /**
     * Delete a staff record.
     */
    public function destroy(Staff $staff): RedirectResponse
    {
        $staff->delete();

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff record deleted successfully.');
    }
}
