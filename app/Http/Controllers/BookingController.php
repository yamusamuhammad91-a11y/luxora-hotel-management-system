<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display the booking form for the selected room.
     */
    public function create(string $slug): View
    {
        $room = Room::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('bookings.create', compact('room'));
    }

    /**
     * Validate and save a guest reservation.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_id' => [
                'required',
                'integer',
                'exists:rooms,id',
            ],

            'guest_name' => [
                'required',
                'string',
                'max:150',
            ],

            'guest_email' => [
                'required',
                'email',
                'max:255',
            ],

            'guest_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'check_in' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'check_out' => [
                'required',
                'date',
                'after:check_in',
            ],

            'adults' => [
                'required',
                'integer',
                'min:1',
                'max:6',
            ],

            'children' => [
                'nullable',
                'integer',
                'min:0',
                'max:6',
            ],

            'rooms_count' => [
                'required',
                'integer',
                'min:1',
                'max:4',
            ],

            'payment_method' => [
                'required',
                'in:online,pay_at_hotel',
            ],

            'booking_acknowledgement' => [
                'required',
                'accepted',
            ],

            'special_requests' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $checkIn = Carbon::parse($validated['check_in'])->startOfDay();
        $checkOut = Carbon::parse($validated['check_out'])->startOfDay();

        $nights = (int) $checkIn->diffInDays($checkOut);
        $children = (int) ($validated['children'] ?? 0);

        $booking = DB::transaction(function () use (
            $validated,
            $checkIn,
            $checkOut,
            $nights,
            $children
        ): Booking {
            /*
             * Lock the room record while validating and creating
             * this reservation to reduce conflicting submissions.
             */
            $room = Room::query()
                ->whereKey($validated['room_id'])
                ->where('is_active', true)
                ->lockForUpdate()
                ->first();

            if (!$room) {
                throw ValidationException::withMessages([
                    'room_id' => 'This room is no longer available. Please select another room.',
                ]);
            }

            /*
             * Check the total guest capacity across the selected
             * number of rooms.
             */
            $totalGuests = (int) $validated['adults'] + $children;

            $totalCapacity = $room->capacity
                * (int) $validated['rooms_count'];

            if ($totalGuests > $totalCapacity) {
                throw ValidationException::withMessages([
                    'adults' => 'The selected number of rooms cannot accommodate all your guests.',
                ]);
            }

            /*
             * Prevent a new reservation from overlapping a
             * confirmed booking for the same room type.
             *
             * This is a basic availability check, not a complete
             * multi-room inventory system.
             */
            $overlapExists = Booking::query()
                ->where('room_id', $room->id)
                ->where('status', 'confirmed')
                ->whereDate(
                    'check_in',
                    '<',
                    $checkOut->toDateString()
                )
                ->whereDate(
                    'check_out',
                    '>',
                    $checkIn->toDateString()
                )
                ->exists();

            if ($overlapExists) {
                throw ValidationException::withMessages([
                    'check_in' => 'A confirmed booking overlaps your selected dates. Please choose different dates or another room type.',
                ]);
            }

            /*
             * Always calculate the price using the database
             * price, never a price supplied by the browser.
             */
            $pricePerNight = (float) $room->price;

            $totalAmount = round(
                $pricePerNight
                * $nights
                * (int) $validated['rooms_count'],
                2
            );

            return Booking::create([
                'booking_reference' => 'LUX-' . Str::upper(
                    Str::random(10)
                ),

                'room_id' => $room->id,

                'guest_name' => $validated['guest_name'],
                'guest_email' => $validated['guest_email'],
                'guest_phone' => $validated['guest_phone'] ?? null,

                'check_in' => $checkIn->toDateString(),
                'check_out' => $checkOut->toDateString(),

                'adults' => (int) $validated['adults'],
                'children' => $children,
                'rooms_count' => (int) $validated['rooms_count'],

                'price_per_night' => $pricePerNight,
                'nights' => $nights,
                'total_amount' => $totalAmount,

                'status' => 'pending',

                'payment_method' => $validated['payment_method'],
                'payment_status' => 'unpaid',

                'special_requests' => $validated['special_requests'] ?? null,
            ]);
        }, 3);

        return redirect()
            ->route('booking.confirmation', [
                'reference' => $booking->booking_reference,
            ])
            ->with(
                'success',
                'Your reservation request has been received.'
            );
    }

    /**
     * Display the reservation confirmation page.
     */
    public function confirmation(string $reference): View
    {
        $booking = Booking::query()
            ->with('room')
            ->where('booking_reference', $reference)
            ->firstOrFail();

        return view('bookings.confirmation', compact('booking'));
    }
}
