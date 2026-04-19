<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        Car::truncate();

        $cars = [
            [
                'name'              => 'Tesla Model 3',
                'type'              => 'electric',
                'image_url'         => 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800',
                'daily_price'       => 1000000,
                'fine_pct_per_hour' => 10,
                'seats'             => 5,
                'status'            => 'ready',
            ],
            [
                'name'              => 'Toyota Avanza',
                'type'              => 'manual',
                'image_url'         => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=800',
                'daily_price'       => 350000,
                'fine_pct_per_hour' => 5,
                'seats'             => 7,
                'status'            => 'ready',
            ],
            [
                'name'              => 'Honda Jazz',
                'type'              => 'manual',
                'image_url'         => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=800',
                'daily_price'       => 400000,
                'fine_pct_per_hour' => 5,
                'seats'             => 5,
                'status'            => 'ready',
            ],
            [
                'name'              => 'Hyundai Ioniq 5',
                'type'              => 'electric',
                'image_url'         => 'https://images.unsplash.com/photo-1619767886558-efdc259cde1a?w=800',
                'daily_price'       => 800000,
                'fine_pct_per_hour' => 8,
                'seats'             => 5,
                'status'            => 'ready',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}