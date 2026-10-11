<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Room Service',
                'slug' => 'room-service',
                'category' => 'food',
                'description' => 'Enjoy delicious meals and refreshments delivered directly to the comfort and privacy of your room.',
                'image' => 'https://images.unsplash.com/photo-1544148103-0773bf10d330?auto=format&fit=crop&w=1000&q=85',
                'price' => 8000,
                'price_type' => 'per_service',
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Laundry',
                'slug' => 'laundry',
                'category' => 'housekeeping',
                'description' => 'Keep your wardrobe fresh throughout your stay with our convenient laundry and garment-care service.',
                'image' => 'https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?auto=format&fit=crop&w=1000&q=85',
                'price' => 5000,
                'price_type' => 'per_service',
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Airport Pickup',
                'slug' => 'airport-pickup',
                'category' => 'transport',
                'description' => 'Arrive in comfort with a convenient airport pickup arranged to make the beginning of your stay effortless.',
                'image' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=1000&q=85',
                'price' => 25000,
                'price_type' => 'per_trip',
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'Spa',
                'slug' => 'spa',
                'category' => 'wellness',
                'description' => 'Step away from the everyday and enjoy a restorative wellness experience designed around relaxation.',
                'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1000&q=85',
                'price' => 18000,
                'price_type' => 'per_session',
                'is_active' => true,
                'display_order' => 4,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::updateOrCreate(
                ['slug' => $serviceData['slug']],
                $serviceData
            );
        }
    }
}
