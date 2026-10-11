<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_rooms' => Room::count(),

            'available_rooms' => Room::where('is_active', true)->count(),

            'total_bookings' => Booking::count(),

            'pending_bookings' => Booking::where('status', 'pending')->count(),

            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),

            'total_guests' => User::where('role', 'guest')->count(),

            'total_services' => Service::count(),

            'active_services' => Service::where('is_active', true)->count(),

            'paid_revenue' => Booking::where('payment_status', 'paid')
                ->sum('total_amount'),
        ];

        $recentBookings = Booking::with('room')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}
