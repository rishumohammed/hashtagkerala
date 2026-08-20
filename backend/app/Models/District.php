<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['name', 'slug', 'title', 'subtitle', 'image_path'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($district) {
            $district->name = $district->title;
        });
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }
}
