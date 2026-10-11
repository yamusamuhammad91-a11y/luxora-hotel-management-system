<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Insert the initial Luxora room catalogue.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Deluxe Room',
                'slug' => 'deluxe-room',
                'description' => 'A refined sanctuary designed for rest and relaxation.',
                'long_description' => 'Experience a welcoming retreat with elegant furnishings, a comfortable king-size bed, and thoughtful amenities. The Deluxe Room offers a relaxing environment for guests who appreciate comfort and understated luxury.',
                'price' => 75000,
                'capacity' => 2,
                'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1000&q=85',
                'features' => [
                    'King-size bed',
                    'City view',
                    'Free Wi-Fi',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Executive Suite',
                'slug' => 'executive-suite',
                'description' => 'Elevated comfort with generous space and elegant details.',
                'long_description' => 'Enjoy a more spacious stay in the Executive Suite, featuring refined interiors, a separate lounge area, and an atmosphere designed for relaxation. It is an excellent choice for guests seeking extra space and elevated comfort.',
                'price' => 95000,
                'capacity' => 2,
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1000&q=85',
                'features' => [
                    'Luxury suite',
                    'Lounge area',
                    'Breakfast option',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Presidential Suite',
                'slug' => 'presidential-suite',
                'description' => 'An exceptional stay with space for the extraordinary.',
                'long_description' => 'Discover an elevated accommodation experience with generous living space, premium furnishings, a separate lounge, and a luxurious bathroom. The Presidential Suite is designed for guests who want additional space and a distinguished stay.',
                'price' => 150000,
                'capacity' => 4,
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1000&q=85',
                'features' => [
                    'Premium suite',
                    'Separate lounge',
                    'Luxury bathroom',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($rooms as $roomData) {
            Room::updateOrCreate(
                ['slug' => $roomData['slug']],
                $roomData
            );
        }
    }
}
