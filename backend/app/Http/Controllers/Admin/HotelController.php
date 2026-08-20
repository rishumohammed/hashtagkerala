<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\Tag;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function index()
    {
        $hotels = Hotel::with('district')->get();
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        $districts = District::all();
        $tags = Tag::all();
        $priceCategories = ['Budget', 'Standard', 'Premium'];
        return view('admin.hotels.create', compact('districts', 'tags', 'priceCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_category' => 'required|string',
            'description' => 'required|string',
            'phone' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'map_embed' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'images' => 'required|array',
            'images.*' => 'image',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle main image_path (use the first uploaded image)
        if ($request->hasFile('images')) {
            $path = $this->imageService->storeProcessedImage($request->file('images')[0], 'images/hotels');
            $validated['image_path'] = $path;
        }

        $hotel = Hotel::create($validated);

        if ($request->has('tags')) {
            $hotel->tags()->sync($request->tags);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $this->imageService->storeProcessedImage($image, 'images/hotels');
                HotelImage::create([
                    'hotel_id' => $hotel->id,
                    'url' => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel created successfully.');
    }

    public function edit(Hotel $hotel)
    {
        $districts = District::all();
        $tags = Tag::all();
        $priceCategories = ['Budget', 'Standard', 'Premium'];
        $hotel->load('tags', 'images');
        return view('admin.hotels.edit', compact('hotel', 'districts', 'tags', 'priceCategories'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_category' => 'required|string',
            'description' => 'required|string',
            'phone' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'map_embed' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'images' => 'nullable|array',
            'images.*' => 'image',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('images')) {
            $path = $this->imageService->storeProcessedImage($request->file('images')[0], 'images/hotels');
            $validated['image_path'] = $path;
        }

        $hotel->update($validated);

        if ($request->has('tags')) {
            $hotel->tags()->sync($request->tags);
        }

        if ($request->hasFile('images')) {
            // Optional: delete old images?
            foreach ($request->file('images') as $image) {
                $path = $this->imageService->storeProcessedImage($image, 'images/hotels');
                HotelImage::create([
                    'hotel_id' => $hotel->id,
                    'url' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted successfully.');
    }
}
