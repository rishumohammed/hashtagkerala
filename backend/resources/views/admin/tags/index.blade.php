@extends('layouts.admin')

@section('header', 'Tags')

@section('content')
<div class="max-w-4xl bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex items-center justify-between">
        <h3 class="font-bold text-slate-800">Manage Hotel Tags</h3>
        <a href="{{ route('admin.tags.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-colors">
            Add Tag
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Added</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($tags as $tag)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-800">
                        <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">{{ $tag->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-sm">{{ $tag->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 text-sm font-medium" onclick="return confirm('Delete this tag?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
