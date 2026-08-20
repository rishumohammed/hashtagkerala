<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DistrictController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function index()
    {
        $districts = District::all();
        return view('admin.districts.index', compact('districts'));
    }

    public function create()
    {
        return view('admin.districts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $path = $this->imageService->storeProcessedImage($request->file('image'), 'images/districts');
            $validated['image_path'] = $path;
        }

        District::create($validated);

        return redirect()->route('admin.districts.index')->with('success', 'District created successfully.');
    }

    public function edit(District $district)
    {
        return view('admin.districts.edit', compact('district'));
    }

    public function update(Request $request, District $district)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $path = $this->imageService->storeProcessedImage($request->file('image'), 'images/districts');
            $validated['image_path'] = $path;
        }

        $district->update($validated);

        return redirect()->route('admin.districts.index')->with('success', 'District updated successfully.');
    }

    public function destroy(District $district)
    {
        $district->delete();
        return redirect()->route('admin.districts.index')->with('success', 'District deleted successfully.');
    }
}
