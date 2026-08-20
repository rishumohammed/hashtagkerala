@extends('layouts.admin')

@section('header', 'Hotels')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex items-center justify-between">
        <h3 class="font-bold text-slate-800">Manage Hotel Listings</h3>
        <a href="{{ route('admin.hotels.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-colors">
            Add Hotel
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">District</th>
                    <th class="px-6 py-4">Location</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Image</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($hotels as $hotel)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $hotel->name }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $hotel->district->name }}</td>
                    <td class="px-6 py-4 text-slate-500 text-sm">{{ $hotel->location }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-slate-100 rounded text-[10px] uppercase font-bold tracking-wider text-slate-600 border border-slate-200">{{ $hotel->price_category }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($hotel->image_path)
                            <img src="{{ asset($hotel->image_path) }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <span class="text-slate-300 italic text-xs">No image</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.hotels.edit', $hotel) }}" class="text-sky-600 hover:text-sky-800 text-sm font-medium">Edit</a>
                        <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 text-sm font-medium" onclick="return confirm('Delete this hotel listing?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
