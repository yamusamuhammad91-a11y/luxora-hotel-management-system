<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $startDate = $validated['start_date']
            ?? now()->startOfMonth()->toDateString();

        $endDate = $validated['end_date']
            ?? now()->endOfMonth()->toDateString();

        $bookingsQuery = Booking::query()
            ->whereDate('check_in', '>=', $startDate)
            ->whereDate('check_in', '<=', $endDate);

        $totalBookings = (clone $bookingsQuery)->count();

        $confirmedBookings = (clone $bookingsQuery)
            ->where('status', 'confirmed')
            ->count();

        $cancelledBookings = (clone $bookingsQuery)
            ->where('status', 'cancelled')
            ->count();

        $pendingBookings = (clone $bookingsQuery)
            ->where('status', 'pending')
            ->count();

        $paidRevenue = (clone $bookingsQuery)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $unpaidAmount = (clone $bookingsQuery)
            ->where('payment_status', 'unpaid')
            ->sum('total_amount');

        $paidBookings = (clone $bookingsQuery)
            ->where('payment_status', 'paid')
            ->count();

        $unpaidBookings = (clone $bookingsQuery)
            ->where('payment_status', 'unpaid')
            ->count();

        $popularRooms = Room::query()
            ->withCount([
                'bookings' => function ($query) use ($startDate, $endDate) {
                    $query->whereDate('check_in', '>=', $startDate)
                        ->whereDate('check_in', '<=', $endDate)
                        ->where('status', '!=', 'cancelled');
                },
            ])
            ->orderByDesc('bookings_count')
            ->orderBy('name')
            ->take(5)
            ->get();

        $dailyBookings = (clone $bookingsQuery)
            ->selectRaw('DATE(check_in) as booking_date, COUNT(*) as total')
            ->groupBy('booking_date')
            ->orderBy('booking_date')
            ->get();

        $dailyRevenue = (clone $bookingsQuery)
            ->where('payment_status', 'paid')
            ->selectRaw('DATE(check_in) as revenue_date, SUM(total_amount) as total')
            ->groupBy('revenue_date')
            ->orderBy('revenue_date')
            ->get();

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalBookings',
            'confirmedBookings',
            'cancelledBookings',
            'pendingBookings',
            'paidRevenue',
            'unpaidAmount',
            'paidBookings',
            'unpaidBookings',
            'popularRooms',
            'dailyBookings',
            'dailyRevenue'
        ));
    }
}
