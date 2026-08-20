@extends('layouts.admin')

@section('header', 'Create District')

@section('content')
<div class="max-w-2xl bg-white rounded-xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('admin.districts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">District Name</label>
            <input type="text" name="name" required class="w-full px-4 py-2 rounded-lg border border-slate-300 outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g. Wayanad">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Display Title</label>
            <input type="text" name="title" required class="w-full px-4 py-2 rounded-lg border border-slate-300 outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g. Green Paradise">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle / Description</label>
            <textarea name="subtitle" rows="3" required class="w-full px-4 py-2 rounded-lg border border-slate-300 outline-none focus:ring-2 focus:ring-emerald-500" placeholder="A brief description for the list view..."></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Featured Image</label>
            <input type="file" name="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
        </div>

        <div class="pt-4 flex items-center space-x-3">
            <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white rounded-lg font-semibold hover:bg-slate-800 transition-colors">
                Save District
            </button>
            <a href="{{ route('admin.districts.index') }}" class="px-6 py-2.5 text-slate-600 hover:text-slate-900 font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
