<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'about_title' => 'About Hashtag Kerala',
            'about_content' => 'Hashtag Kerala is more than just a travel platform; it is a curated window into the soul of God\'s Own Country. We believe that travel should be a calm, intentional experience that connects you with the heritage, nature, and people of Kerala.',
            'about_mission' => 'Our mission is to simplify the discovery of premium stays and hidden gems, moving away from cluttered search results to a refined collection of houseboats, tea-country retreats, and coastal hideaways.',
            'about_vision' => 'To become the premier cinematic guide for the modern traveler seeking authentic Kerala experiences with a touch of luxury and tranquility.',
            'contact_email' => 'hello@hashtagkerala.com',
            'contact_phone' => '+91 98765 43210',
            'social_instagram' => 'https://instagram.com/hashtagkerala',
            'social_youtube' => 'https://youtube.com/hashtagkerala',
            'hero_youtube_id' => 'm7CR9A2sgok',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
