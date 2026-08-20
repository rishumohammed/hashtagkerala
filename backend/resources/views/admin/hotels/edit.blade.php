@extends('layouts.admin')

@section('header', 'Edit Hotel: ' . $hotel->name)

@section('content')
<div class="max-w-4xl bg-white rounded-xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('admin.hotels.update', $hotel) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column: Basic Info -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Hotel Name</label>
                    <input type="text" name="name" value="{{ old('name', $hotel->name) }}" required class="w-full px-4 py-2 rounded-lg border border-slate-300 outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">District</label>
                    <select name="district_id" required class="w-full px-4 py-2 rounded-lg border border-slate-300 outline-none focus:ring-2 focus:ring-emerald-500">
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ $hotel->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Specific Location</label>
                    <input type="text" name="location" value="{{ old('location', $hotel->location) }}" required class="w-full px-4 py-2 rounded-lg border border-slate-300 outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Price Category</label>
                    <div class="flex space-x-4">
                        @foreach($priceCategories as $category)
                        <label class="flex items-center">
                            <input type="radio" name="price_category" value="{{ $category }}" {{ $hotel->price_category == $category ? 'checked' : '' }} required class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                            <span class="ml-2 text-sm text-slate-600">{{ $category }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Contact Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $hotel->phone) }}" class="w-full px-4 py-2 rounded-lg border border-slate-300 outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <!-- Right Column: More Info -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tags (Multiple)</label>
                    <div class="grid grid-cols-2 gap-2 h-48 overflow-y-auto p-4 border border-slate-200 rounded-lg bg-slate-50">
                        @foreach($tags as $tag)
                        <label class="flex items-center">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ $hotel->tags->contains($tag->id) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                            <span class="ml-2 text-xs text-slate-600">{{ $tag->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Upload More Images</label>
                    <div class="flex gap-2 overflow-x-auto mb-2">
                        @foreach($hotel->images as $img)
                            <img src="{{ asset($img->url) }}" class="w-16 h-12 rounded object-cover border border-slate-200 shadow-sm opacity-50">
                        @endforeach
                    </div>
                    <input type="file" name="images[]" multiple class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Hotel description</label>
            <textarea name="description" rows="5" required class="w-full px-4 py-2 rounded-lg border border-slate-300 outline-none focus:ring-2 focus:ring-emerald-500">{{ old('description', $hotel->description) }}</textarea>
        </div>

        <div class="pt-4 flex items-center space-x-3 border-t border-slate-100 mt-8">
            <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 transition-colors shadow-lg shadow-slate-200">
                Update Hotel Listing
            </button>
            <a href="{{ route('admin.hotels.index') }}" class="px-8 py-3 text-slate-600 hover:text-slate-900 font-semibold text-sm transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
