@extends('layouts.admin')

@section('header', 'Add New Tag')

@section('content')
<div class="max-w-md bg-white rounded-xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('admin.tags.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Tag Name</label>
            <input type="text" name="name" required class="w-full px-4 py-2 rounded-lg border border-slate-300 outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g. Backwater">
            @error('name')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex items-center space-x-3">
            <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white rounded-lg font-semibold hover:bg-slate-800 transition-colors">
                Create Tag
            </button>
            <a href="{{ route('admin.tags.index') }}" class="px-6 py-2.5 text-slate-600 hover:text-slate-900 font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
