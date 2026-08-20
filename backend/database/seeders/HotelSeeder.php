<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\District;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            // Alleppey
            [
                'name' => 'Lake Crest Houseboat',
                'slug' => 'lake-crest-houseboat',
                'district_slug' => 'alleppey',
                'location' => 'Punnamada Lake',
                'price_category' => 'Premium',
                'image_path' => '/assets/images/kerala_luxury_hotel.jpg',
            ],
            [
                'name' => 'Canal Breeze Inn',
                'slug' => 'canal-breeze-inn',
                'district_slug' => 'alleppey',
                'location' => 'Vembanad Backwaters',
                'price_category' => 'Budget',
                'image_path' => '/assets/images/kerala_backwaters.jpg',
            ],
            // Munnar (Idukki)
            [
                'name' => 'Munnar Cloud House',
                'slug' => 'munnar-cloud-house',
                'district_slug' => 'idukki',
                'location' => 'Pothamedu View Point',
                'price_category' => 'Standard',
                'image_path' => '/assets/images/kerala_tea_hills.jpg',
            ],
            [
                'name' => 'Tea Garden Retreat',
                'slug' => 'tea-garden-retreat',
                'district_slug' => 'idukki',
                'location' => 'Old Munnar',
                'price_category' => 'Premium',
                'image_path' => '/assets/images/kerala_luxury_hotel.jpg',
            ],
            // Kochi (Ernakulam)
            [
                'name' => 'Fort Kochi Veranda',
                'slug' => 'fort-kochi-veranda',
                'district_slug' => 'kochi',
                'location' => 'Princess Street',
                'price_category' => 'Standard',
                'image_path' => '/assets/images/kerala_heritage.jpg',
            ],
            // Wayanad
            [
                'name' => 'Wayanad Forest Mist',
                'slug' => 'wayanad-forest-mist',
                'district_slug' => 'wayanad',
                'location' => 'Lakkidi',
                'price_category' => 'Premium',
                'image_path' => '/assets/images/kerala_tea_hills.jpg',
            ],
            // Kasaragod
            [
                'name' => 'Bekal Fort Resort',
                'slug' => 'bekal-fort-resort',
                'district_slug' => 'kasaragod',
                'location' => 'Bekal Beach',
                'price_category' => 'Premium',
                'image_path' => '/assets/images/kerala_luxury_hotel.jpg',
            ],
        ];

        foreach ($hotels as $hotel) {
            $district = District::where('slug', $hotel['district_slug'])->first();
            if ($district) {
                Hotel::updateOrCreate(
                    ['slug' => $hotel['slug']],
                    [
                        'name' => $hotel['name'],
                        'district_id' => $district->id,
                        'location' => $hotel['location'],
                        'price_category' => $hotel['price_category'],
                        'image_path' => $hotel['image_path'],
                        'description' => 'Experience the best of ' . $district->title . ' in this curated stay.',
                    ]
                );
            }
        }
    }
}
