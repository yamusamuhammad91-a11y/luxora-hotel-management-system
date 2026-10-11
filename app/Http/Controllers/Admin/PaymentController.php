<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Display payment records derived from bookings.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => [
                'nullable',
                Rule::in(['paid', 'unpaid', 'refunded', 'failed']),
            ],
            'method' => [
                'nullable',
                Rule::in(['online', 'pay_at_hotel']),
            ],
        ]);

        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? null;
        $method = $validated['method'] ?? null;

        $paymentsQuery = Booking::query()
            ->with('room')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('booking_reference', 'like', "%{$search}%")
                        ->orWhere('guest_name', 'like', "%{$search}%")
                        ->orWhere('guest_email', 'like', "%{$search}%")
                        ->orWhere('payment_reference', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('payment_status', $status);
            })
            ->when($method, function ($query, $method) {
                $query->where('payment_method', $method);
            })
            ->latest();

        $payments = $paymentsQuery
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total_records' => Booking::count(),

            'paid_revenue' => Booking::where('payment_status', 'paid')
                ->sum('total_amount'),

            'pending_amount' => Booking::where('payment_status', 'unpaid')
                ->sum('total_amount'),

            'paid_count' => Booking::where('payment_status', 'paid')
                ->count(),
        ];

        return view('admin.payments.index', compact(
            'payments',
            'stats',
            'search',
            'status',
            'method'
        ));
    }
}
