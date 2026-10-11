<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\View\View;

class RoomController extends Controller
{
    /**
     * Display all active rooms.
     */
    public function index(): View
    {
        $rooms = Room::query()
            ->where('is_active', true)
            ->orderBy('price')
            ->get()
            ->map(fn (Room $room) => $this->formatRoom($room))
            ->all();

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Display one room and other active rooms.
     */
    public function show(string $slug): View
    {
        $roomModel = Room::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $room = $this->formatRoom($roomModel);

        $otherRooms = Room::query()
            ->where('is_active', true)
            ->where('id', '!=', $roomModel->id)
            ->orderBy('price')
            ->limit(3)
            ->get()
            ->map(fn (Room $otherRoom) => $this->formatRoom($otherRoom))
            ->all();

        return view('rooms.show', compact('room', 'otherRooms'));
    }

    /**
     * Convert a Room model into the array format used by the current views.
     */
    private function formatRoom(Room $room): array
    {
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
    }
}
