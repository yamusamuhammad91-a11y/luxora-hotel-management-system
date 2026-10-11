<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoomController extends Controller
{
    /**
     * Display all rooms in the admin area.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
        ]);

        $rooms = Room::query()
            ->when($validated['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($validated['status'] ?? null, function ($query, $status) {
                $query->where(
                    'is_active',
                    $status === 'active'
                );
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total' => Room::count(),
            'active' => Room::where('is_active', true)->count(),
            'inactive' => Room::where('is_active', false)->count(),
        ];

        return view('admin.rooms.index', compact('rooms', 'stats'));
    }

    /**
     * Show the create-room form.
     */
    public function create(): View
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a new room.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:rooms,slug'],
            'description' => ['required', 'string'],
            'long_description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'capacity' => ['required', 'integer', 'min:1', 'max:100'],
            'image' => ['nullable', 'url', 'max:2048'],
            'features' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['name']
        );

        $validated['features'] = $this->parseFeatures(
            $validated['features'] ?? ''
        );

        $validated['is_active'] = $request->boolean('is_active');

        Room::create($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room created successfully.');
    }

    /**
     * Show the edit-room form.
     */
    public function edit(Room $room): View
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update an existing room.
     */
    public function update(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rooms', 'slug')->ignore($room->id),
            ],
            'description' => ['required', 'string'],
            'long_description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'capacity' => ['required', 'integer', 'min:1', 'max:100'],
            'image' => ['nullable', 'url', 'max:2048'],
            'features' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['name'],
            $room->id
        );

        $validated['features'] = $this->parseFeatures(
            $validated['features'] ?? ''
        );

        $validated['is_active'] = $request->boolean('is_active');

        $room->update($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Toggle whether a room appears as active on the public website.
     */
    public function toggleStatus(Room $room): RedirectResponse
    {
        $room->update([
            'is_active' => ! $room->is_active,
        ]);

        return redirect()
            ->route('admin.rooms.index')
            ->with(
                'success',
                $room->is_active
                    ? 'Room activated successfully.'
                    : 'Room deactivated successfully.'
            );
    }

    /**
     * Delete a room when it has no associated bookings.
     */
    public function destroy(Room $room): RedirectResponse
    {
        if ($room->bookings()->exists()) {
            return redirect()
                ->route('admin.rooms.index')
                ->withErrors([
                    'room' => 'This room has booking records and cannot be deleted. Deactivate it instead.',
                ]);
        }

        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully.');
    }

    /**
     * Generate a unique URL slug.
     */
    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value);

        if ($baseSlug === '') {
            $baseSlug = 'room';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            Room::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Convert newline-separated feature text into an array.
     */
    private function parseFeatures(string $features): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $features) ?: [])
            ->map(fn ($feature) => trim($feature))
            ->filter(fn ($feature) => $feature !== '')
            ->unique()
            ->values()
            ->all();
    }
}
