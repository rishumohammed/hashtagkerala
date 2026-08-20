@extends('layouts.admin')

@section('header', 'Districts')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex items-center justify-between">
        <h3 class="font-bold text-slate-800">Manage Districts</h3>
        <a href="{{ route('admin.districts.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-colors">
            Add District
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Subtitle</th>
                    <th class="px-6 py-4">Image</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($districts as $district)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $district->name }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $district->title }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ Str::limit($district->subtitle, 40) }}</td>
                    <td class="px-6 py-4">
                        @if($district->image_path)
                            <img src="{{ asset($district->image_path) }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <span class="text-slate-300">No image</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.districts.edit', $district) }}" class="text-sky-600 hover:text-sky-800 text-sm font-medium">Edit</a>
                        <form action="{{ route('admin.districts.destroy', $district) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 text-sm font-medium" onclick="return confirm('Delete this district?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
