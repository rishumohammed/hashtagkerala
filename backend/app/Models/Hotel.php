<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'district_id', 'name', 'slug', 'location', 'price_category', 
        'hotel_type', 'category', 'description', 'phone', 'whatsapp', 
        'map_embed', 'tone', 'amenities', 'features', 'room_types', 
        'gallery', 'image_path', 'nearby_attractions', 'how_to_reach', 'is_featured'
    ];

    protected $casts = [
        'amenities' => 'array',
        'features' => 'array',
        'room_types' => 'array',
        'gallery' => 'array',
        'is_featured' => 'boolean',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
