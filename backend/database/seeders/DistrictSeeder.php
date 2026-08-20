<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            [
                'name' => 'Thiruvananthapuram',
                'slug' => 'thiruvananthapuram',
                'title' => 'Thiruvananthapuram',
                'subtitle' => 'The majestic capital city, home to historic temples, golden beaches, and colonial heritage.',
                'image_path' => '/assets/images/kerala_heritage.jpg',
            ],
            [
                'name' => 'Kollam',
                'slug' => 'kollam',
                'title' => 'Kollam',
                'subtitle' => 'The gateway to Kerala\'s backwaters, where ancient trade history meets the serene Ashtamudi Lake.',
                'image_path' => '/assets/images/kerala_backwaters.jpg',
            ],
            [
                'name' => 'Alappuzha',
                'slug' => 'alleppey',
                'title' => 'Alappuzha',
                'subtitle' => 'The Venice of the East, famous for its iconic houseboats and endless emerald backwaters.',
                'image_path' => '/assets/images/kerala_backwaters.jpg',
            ],
            [
                'name' => 'Pathanamthitta',
                'slug' => 'pathanamthitta',
                'title' => 'Pathanamthitta',
                'subtitle' => 'The pilgrim heart of Kerala, surrounded by lush forests and the sacred Pamba River.',
                'image_path' => '/assets/images/kerala_tea_hills.jpg',
            ],
            [
                'name' => 'Kottayam',
                'slug' => 'kottayam',
                'title' => 'Kottayam',
                'subtitle' => 'The land of letters and latex, home to the scenic Kumarakom backwaters and vast rubber plantations.',
                'image_path' => '/assets/images/kerala_backwaters.jpg',
            ],
            [
                'name' => 'Idukki',
                'slug' => 'idukki',
                'title' => 'Idukki',
                'subtitle' => 'High-range wonders featuring misty tea gardens of Munnar and the massive Idukki Arch Dam.',
                'image_path' => '/assets/images/kerala_tea_hills.jpg',
            ],
            [
                'name' => 'Ernakulam',
                'slug' => 'kochi',
                'title' => 'Ernakulam',
                'subtitle' => 'A vibrant blend of modern city life and the timeless heritage of Fort Kochi.',
                'image_path' => '/assets/images/kerala_heritage.jpg',
            ],
            [
                'name' => 'Thrissur',
                'slug' => 'thrissur',
                'title' => 'Thrissur',
                'subtitle' => 'The cultural capital, where grand festivals and ancient architecture define the spirit of Kerala.',
                'image_path' => '/assets/images/kerala_heritage.jpg',
            ],
            [
                'name' => 'Palakkad',
                'slug' => 'palakkad',
                'title' => 'Palakkad',
                'subtitle' => 'The granary of Kerala, marked by vast paddy fields and the majestic Palakkad Fort.',
                'image_path' => '/assets/images/kerala_tea_hills.jpg',
            ],
            [
                'name' => 'Malappuram',
                'slug' => 'malappuram',
                'title' => 'Malappuram',
                'subtitle' => 'A region rich in history and greenery, from the teak forests of Nilambur to the hills of Arimbra.',
                'image_path' => '/assets/images/kerala_tea_hills.jpg',
            ],
            [
                'name' => 'Kozhikode',
                'slug' => 'kozhikode',
                'title' => 'Kozhikode',
                'subtitle' => 'The city of spices, where historic coastlines meet world-renowned culinary traditions.',
                'image_path' => '/assets/images/kerala_beach.jpg',
            ],
            [
                'name' => 'Wayanad',
                'slug' => 'wayanad',
                'title' => 'Wayanad',
                'subtitle' => 'A pristine wilderness of tribal heritage, ancient caves, and lush mountain hideaways.',
                'image_path' => '/assets/images/kerala_tea_hills.jpg',
            ],
            [
                'name' => 'Kannur',
                'slug' => 'kannur',
                'title' => 'Kannur',
                'subtitle' => 'The land of looms and lore, famous for its rhythmic Theyyam art and unspoiled beaches.',
                'image_path' => '/assets/images/kerala_beach.jpg',
            ],
            [
                'name' => 'Kasaragod',
                'slug' => 'kasaragod',
                'title' => 'Kasaragod',
                'subtitle' => 'The northern frontier, home to the iconic Bekal Fort and a mosaic of diverse cultures.',
                'image_path' => '/assets/images/kerala_beach.jpg',
            ],
        ];

        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        District::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        foreach ($districts as $district) {
            District::create($district);
        }
    }
}
