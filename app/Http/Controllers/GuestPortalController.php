<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class GuestPortalController extends Controller
{
    /**
     * Display the authenticated guest's reservations.
     */
    public function index(Request $request)
    {
        $email = $request->user()->email;

        $bookings = Booking::with('room')
            ->whereRaw('LOWER(guest_email) = ?', [strtolower($email)])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Booking::whereRaw(
                'LOWER(guest_email) = ?',
                [strtolower($email)]
            )->count(),

            'upcoming' => Booking::whereRaw(
                'LOWER(guest_email) = ?',
                [strtolower($email)]
            )
                ->whereDate('check_in', '>=', now()->toDateString())
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),

            'completed' => Booking::whereRaw(
                'LOWER(guest_email) = ?',
                [strtolower($email)]
            )
                ->whereDate('check_out', '<', now()->toDateString())
                ->where('status', '!=', 'cancelled')
                ->count(),
        ];

        return view('guest.dashboard', compact('bookings', 'stats'));
    }

    /**
     * Display a reservation belonging to the authenticated guest.
     */
    public function show(Request $request, Booking $booking)
    {
        abort_unless(
            strtolower($booking->guest_email) ===
                strtolower($request->user()->email),
            404
        );

        $booking->load('room');

        return view('guest.bookings.show', compact('booking'));
    }
}
