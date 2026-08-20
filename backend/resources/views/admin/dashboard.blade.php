@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Districts</h3>
            <span class="p-2 bg-emerald-50 rounded-lg">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-slate-900">{{ $stats['districts'] }}</div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-slate-500 uppercase tracking-wider">Hotels Listed</h3>
            <span class="p-2 bg-sky-50 rounded-lg">
                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-slate-900">{{ $stats['hotels'] }}</div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-slate-500 uppercase tracking-wider">Active Tags</h3>
            <span class="p-2 bg-amber-50 rounded-lg">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-slate-900">{{ $stats['tags'] }}</div>
    </div>
</div>

<div class="mt-8">
    <div class="bg-indigo-900 rounded-2xl p-8 text-white flex items-center justify-between overflow-hidden relative">
        <div class="relative z-10">
            <h3 class="text-2xl font-bold mb-2">Welcome to your dashboard!</h3>
            <p class="text-indigo-200">Manage your hotel listings and districts for Hashtag Kerala.</p>
            <div class="mt-6 flex space-x-3">
                <a href="{{ route('admin.hotels.create') }}" class="px-4 py-2 bg-white text-indigo-900 rounded-lg font-semibold text-sm hover:bg-slate-100 transition-colors">
                    Add New Hotel
                </a>
                <a href="{{ route('admin.districts.index') }}" class="px-4 py-2 bg-indigo-800 text-white border border-indigo-700 rounded-lg font-semibold text-sm hover:bg-indigo-700 transition-colors">
                    Manage Districts
                </a>
            </div>
        </div>
        <div class="absolute -right-20 -bottom-20 opacity-10">
            <svg class="w-80 h-80" fill="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </div>
    </div>
</div>
@endsection
