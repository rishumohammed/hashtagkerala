<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GalleryItem;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'image' => '/assets/images/kerala_tea_hills.jpg',
                'title' => 'Misty Munnar Hills',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'image' => '/assets/images/kerala_backwaters.jpg',
                'title' => 'Alleppey Backwaters',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'image' => '/assets/images/kerala_heritage.jpg',
                'title' => 'Fort Kochi Heritage',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'image' => '/assets/images/kerala_tea_hills.jpg',
                'title' => 'Wayanad Forests',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'image' => '/assets/images/kerala_beach.jpg',
                'title' => 'Varkala Cliff Sunset',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'image' => '/assets/images/kerala_backwaters.jpg',
                'title' => 'Athirappilly Waterfalls',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            GalleryItem::create($item);
        }
    }
}
