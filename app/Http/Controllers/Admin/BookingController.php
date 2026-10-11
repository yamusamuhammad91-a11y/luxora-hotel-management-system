<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display and filter hotel bookings.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => [
                'nullable',
                Rule::in([
                    'pending',
                    'confirmed',
                    'cancelled',
                ]),
            ],
        ]);

        $bookings = Booking::query()
            ->with('room')
            ->when($validated['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('booking_reference', 'like', "%{$search}%")
                        ->orWhere('guest_name', 'like', "%{$search}%")
                        ->orWhere('guest_email', 'like', "%{$search}%");
                });
            })
            ->when($validated['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    /**
     * Update a booking's administrative status.
     */
    public function updateStatus(
        Request $request,
        Booking $booking
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'confirmed',
                    'cancelled',
                ]),
            ],
        ]);

        if ($booking->status === 'cancelled'
            && $validated['status'] !== 'cancelled') {
            return back()->withErrors([
                'status' => 'A cancelled booking cannot be reopened from this screen.',
            ]);
        }

        $booking->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking status updated successfully.');
    }
}
