<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Hashtag Kerala</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex-shrink-0">
            <div class="p-6">
                <h1 class="text-xl font-bold tracking-tight">Hashtag <span class="text-emerald-400">Kerala</span></h1>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-semibold">Admin Panel</p>
            </div>
            <nav class="mt-4 px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-emerald-400' : 'text-slate-300 hover:bg-slate-800' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.districts.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.districts.*') ? 'bg-slate-800 text-emerald-400' : 'text-slate-300 hover:bg-slate-800' }}">
                    Districts
                </a>
                <a href="{{ route('admin.hotels.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.hotels.*') ? 'bg-slate-800 text-emerald-400' : 'text-slate-300 hover:bg-slate-800' }}">
                    Hotels
                </a>
                <a href="{{ route('admin.tags.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.tags.*') ? 'bg-slate-800 text-emerald-400' : 'text-slate-300 hover:bg-slate-800' }}">
                    Tags
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-4 border-t border-slate-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-400 hover:text-white transition-colors">
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-8">
                <h2 class="text-lg font-semibold text-slate-800">
                    @yield('header', 'Dashboard')
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-slate-500">{{ Auth::user()->email }}</span>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
