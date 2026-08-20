<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hashtagkerala.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        $this->call([
            SiteSettingSeeder::class,
            ArticleSeeder::class,
            DistrictSeeder::class,
            TagSeeder::class,
            HotelSeeder::class,
            GallerySeeder::class,
        ]);
    }
}
