<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Backwater', 'Beachfront', 'Private deck', 'Spa', 
            'Family rooms', 'Breakfast', 'Pool', 'Heritage', 
            'Boutique', 'City stay', 'Art district', 'Lagoon', 
            'Sunset cruise', 'Town stay', 'Canal view', 'Private villa', 
            'Couple friendly', 'Boat access', 'Beach access', 
            'Flexible stay', 'Local food', 'Quiet zone', 'Hill escape', 
            'Mountain view', 'Tea estate', 'Rainforest', 'Forest view',
            'Business', 'Waterfront', 'Curated stay', 'Premium layout', 'Responsive'
        ];

        foreach ($tags as $tag) {
            \App\Models\Tag::updateOrCreate(['name' => $tag]);
        }
    }
}
