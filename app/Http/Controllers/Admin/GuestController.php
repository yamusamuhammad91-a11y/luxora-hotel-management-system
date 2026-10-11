<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GuestController extends Controller
{
    /**
     * Display the guest directory.
     *
     * Guests are identified by their email address from existing bookings.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'sort' => [
                'nullable',
                Rule::in(['recent', 'name', 'bookings']),
            ],
        ]);

        $search = $validated['search'] ?? null;
        $sort = $validated['sort'] ?? 'recent';

        $guestsQuery = DB::table('bookings')
            ->select([
                'guest_email',
                DB::raw('MAX(guest_name) as guest_name'),
                DB::raw('MAX(guest_phone) as guest_phone'),
                DB::raw('COUNT(*) as bookings_count'),
                DB::raw('MAX(check_in) as last_check_in'),
                DB::raw('MAX(check_out) as last_check_out'),
                DB::raw('MAX(created_at) as last_booking_at'),
            ])
            ->whereNotNull('guest_email')
            ->where('guest_email', '!=', '')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('guest_name', 'like', "%{$search}%")
                        ->orWhere('guest_email', 'like', "%{$search}%")
                        ->orWhere('guest_phone', 'like', "%{$search}%");
                });
            })
            ->groupBy('guest_email');

        if ($sort === 'name') {
            $guestsQuery->orderBy('guest_name');
        } elseif ($sort === 'bookings') {
            $guestsQuery->orderByDesc('bookings_count');
        } else {
            $guestsQuery->orderByDesc('last_booking_at');
        }

        $guests = $guestsQuery
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total_guests' => DB::table('bookings')
                ->whereNotNull('guest_email')
                ->where('guest_email', '!=', '')
                ->distinct()
                ->count('guest_email'),

            'total_bookings' => DB::table('bookings')->count(),

            'returning_guests' => DB::table('bookings')
                ->whereNotNull('guest_email')
                ->where('guest_email', '!=', '')
                ->select('guest_email')
                ->groupBy('guest_email')
                ->havingRaw('COUNT(*) > 1')
                ->get()
                ->count(),
        ];

        return view('admin.guests.index', compact(
            'guests',
            'stats',
            'search',
            'sort'
        ));
    }
}
