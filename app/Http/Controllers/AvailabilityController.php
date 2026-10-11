<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AvailabilityController extends Controller
{
    /**
     * Search active room types using the guest's search criteria.
     *
     * Note: This filters room types. Actual date-by-date inventory
     * and booking conflict checks will be implemented separately.
     */
    public function index(Request $request): View
    {
        $search = $request->validate([
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
            'rooms' => [
                'required',
                'integer',
                'min:1',
                'max:4',
            ],
            'room' => [
                'nullable',
                'string',
                'exists:rooms,slug',
            ],
        ]);

        $checkIn = Carbon::parse($search['check_in'])->startOfDay();
        $checkOut = Carbon::parse($search['check_out'])->startOfDay();

        $nights = (int) $checkIn->diffInDays($checkOut);

        // Estimate the minimum capacity needed per requested room.
        $capacityPerRoom = (int) ceil(
            $search['adults'] / $search['rooms']
        );

        $roomQuery = Room::query()
            ->where('is_active', true)
            ->where('capacity', '>=', $capacityPerRoom)
            ->orderBy('price');

        if (!empty($search['room'])) {
            $roomQuery->where('slug', $search['room']);
        }

        $rooms = $roomQuery
            ->get()
            ->map(function (Room $room): array {
                return [
                    'id' => $room->id,
                    'name' => $room->name,
                    'slug' => $room->slug,
                    'description' => $room->description,
                    'long_description' => $room->long_description
                        ?: $room->description,
                    'price' => (float) $room->price,
                    'capacity' => $room->capacity,
                    'image' => $room->image,
                    'features' => $room->features ?? [],
                ];
            })
            ->all();

        return view('availability.index', [
            'rooms' => $rooms,
            'search' => $search,
            'nights' => $nights,
        ]);
    }
}
