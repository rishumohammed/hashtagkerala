<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('hotel_type')->nullable()->after('price_category');
            $table->string('category')->nullable()->after('hotel_type');
            $table->json('features')->nullable()->after('amenities');
            $table->json('room_types')->nullable()->after('features');
            $table->json('gallery')->nullable()->after('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn([
                'hotel_type',
                'category',
                'features',
                'room_types',
                'gallery',
            ]);
        });
    }
};
