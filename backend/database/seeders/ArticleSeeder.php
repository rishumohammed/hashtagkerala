<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Nehru Trophy Boat Race Dates Announced',
                'slug' => Str::slug('Nehru Trophy Boat Race Dates Announced'),
                'content' => '<p>The iconic Nehru Trophy Boat Race, held annually on the Punnamada Lake in Alappuzha, has officially announced its dates for this year. Thousands of spectators are expected to gather to witness the snake boats racing to the finish line.</p><p>Experience the rhythmic chants of the oarsmen and the vibrant energy of Kerala\'s most celebrated water festival.</p>',
                'image' => '/assets/images/kerala_backwaters.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Monsoon Tourism in Wayanad Peaks',
                'slug' => Str::slug('Monsoon Tourism in Wayanad Peaks'),
                'content' => '<p>Wayanad district is gearing up for the monsoon tourism season. The lush green mountains, overflowing waterfalls, and misty mornings make it a perfect getaway for nature lovers.</p><p>Local resorts are offering special Ayurveda and wellness packages to complement the soothing climate.</p>',
                'image' => '/assets/images/kerala_tea_hills.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Heritage Walks Introduced in Fort Kochi',
                'slug' => Str::slug('Heritage Walks Introduced in Fort Kochi'),
                'content' => '<p>The tourism department has introduced guided heritage walks in Fort Kochi. Tourists can now explore the colonial architecture, the iconic Chinese fishing nets, and the historic spice markets with expert local guides.</p><p>This initiative aims to promote sustainable and immersive tourism in the historic coastal town.</p>',
                'image' => '/assets/images/kerala_heritage.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ]
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(['slug' => $article['slug']], $article);
        }
    }
}
