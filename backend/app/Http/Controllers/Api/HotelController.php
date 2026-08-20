<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Hotel::with(['district', 'tags']);

        if ($request->has('district')) {
            $query->whereHas('district', function ($q) use ($request) {
                $q->where('slug', $request->district);
            });
        }

        // Support both 'category' and 'price_category' filters
        $category = $request->input('category') ?? $request->input('price_category');
        if ($category) {
            $query->where('price_category', $category);
        }

        if ($request->has('tags')) {
            $tags = is_array($request->tags) ? $request->tags : [$request->tags];
            foreach ($tags as $tag) {
                $query->whereHas('tags', function ($q) use ($tag) {
                    $q->where('name', $tag);
                });
            }
        }

        $hotels = $query->get()->map(function ($hotel) {
            if ($hotel->image_path) {
                if (str_starts_with($hotel->image_path, '/assets/')) {
                    $hotel->image = $hotel->image_path;
                } else {
                    $hotel->image = filter_var($hotel->image_path, FILTER_VALIDATE_URL) 
                        ? $hotel->image_path 
                        : asset('storage/' . $hotel->image_path);
                }
            }
            $hotel->category = $hotel->category ?? $hotel->price_category; // Fallback for frontend
            $hotel->priceClass = 'badge-' . strtolower($hotel->category ?? $hotel->price_category);
            $hotel->district_slug = $hotel->district->slug; // Added for Clean URLs
            $hotel->is_featured = (bool) $hotel->is_featured;
            
            $hotel->gallery_images = collect($hotel->gallery ?? [])->map(function ($img) {
                if (str_starts_with($img, '/assets/')) {
                    return ['url' => $img, 'full_url' => $img];
                } else {
                    $url = filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/' . $img);
                    return ['url' => $url, 'full_url' => $url];
                }
            })->all();

            return $hotel;
        });

        return response()->json([
            'status' => 'success',
            'data' => $hotels
        ]);
    }

    public function show($slug)
    {
        $hotel = \App\Models\Hotel::with(['district', 'tags'])->where('slug', $slug)->firstOrFail();
        
        $data = [
            'id' => $hotel->id,
            'name' => $hotel->name,
            'slug' => $hotel->slug,
            'description' => $hotel->description,
            'location' => $hotel->location,
            'phone' => $hotel->phone,
            'whatsapp' => $hotel->whatsapp,
            'map_embed' => $hotel->map_embed,
            'district' => $hotel->district->name,
            'price_category' => $hotel->price_category,
            'priceCategory' => $hotel->price_category,
            'priceClass' => 'badge-' . strtolower($hotel->price_category),
            'category' => $hotel->price_category, // Alias
            'categoryClass' => 'badge-' . strtolower($hotel->category ?? $hotel->price_category),
            'image' => str_starts_with($hotel->image_path ?? '', '/assets/') ? $hotel->image_path : (filter_var($hotel->image_path, FILTER_VALIDATE_URL) ? $hotel->image_path : ($hotel->image_path ? asset('storage/' . $hotel->image_path) : null)),
            'tagNames' => $hotel->tags->pluck('name'),
            'tags' => $hotel->tags->pluck('name'),
            'amenities' => $this->getAmenitiesWithIcons($hotel->amenities ?? []),
            'features' => $hotel->features ?? [],
            'hotel_type' => $hotel->hotel_type,
            'room_types' => $hotel->room_types ?? [],
            'nearby_attractions' => $hotel->nearby_attractions,
            'how_to_reach' => $hotel->how_to_reach,
            'tone' => $this->getToneForDistrict($hotel->district->slug),
            'images' => collect($hotel->gallery ?? [])->map(function ($img) {
                $url = str_starts_with($img, '/assets/') ? $img : (filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/' . $img));
                return ['url' => $url, 'full_url' => $url, 'title' => 'Gallery Image'];
            })->all()
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    protected function getAmenitiesWithIcons($hotelAmenities)
    {
        if (empty($hotelAmenities)) return [];
        
        $settingsJson = \App\Models\SiteSetting::where('key', 'hotel_amenities')->value('value');
        $allAmenities = $settingsJson ? json_decode($settingsJson, true) : [];
        
        // Map configured amenities by name to their icon
        $iconMap = [];
        if (!empty($allAmenities) && is_array(reset($allAmenities))) {
            foreach ($allAmenities as $am) {
                if (isset($am['name']) && isset($am['icon'])) {
                    $iconMap[$am['name']] = $am['icon'];
                }
            }
        }
        
        $result = [];
        foreach ($hotelAmenities as $name) {
            $iconName = $iconMap[$name] ?? 'heroicon-o-check-circle';
            $svgContent = '';
            
            try {
                // Use blade-icons to render the raw SVG, stripped of classes if we want to apply them in vue,
                // or just let it render with our custom class.
                $svgContent = svg($iconName, 'w-5 h-5 text-brand-primary')->toHtml();
            } catch (\Exception $e) {
                // Fallback icon if not found
                $svgContent = '<svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            }
            
            $result[] = [
                'name' => $name,
                'icon' => $svgContent
            ];
        }
        
        return $result;
    }

    protected function getToneForDistrict($slug)
    {
        $tones = [
            'alleppey' => 'from-sky-700 via-cyan-500 to-emerald-500',
            'munnar' => 'from-emerald-800 via-green-700 to-lime-500',
            'kochi' => 'from-slate-800 via-sky-700 to-cyan-500',
            'wayanad' => 'from-green-950 via-emerald-800 to-teal-500',
        ];

        return $tones[$slug] ?? 'from-slate-700 via-sky-700 to-cyan-500';
    }
}
