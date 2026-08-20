<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return GalleryItem::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->map(function ($item) {
                if ($item->image) {
                    if (str_starts_with($item->image, '/assets/')) {
                        $item->image = $item->image;
                    } else {
                        $item->image = filter_var($item->image, FILTER_VALIDATE_URL) 
                            ? $item->image 
                            : asset('storage/' . $item->image);
                    }
                }
                return $item;
            });
    }
}
