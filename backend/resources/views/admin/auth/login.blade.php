<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hashtag Kerala Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-100">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Sign in to Admin</h1>
            <p class="text-slate-500 text-sm mt-2">Enter your credentials to manage Kerala stays</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email" required 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                    placeholder="admin@hashtagkerala.com" value="{{ old('email') }}">
                @error('email')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                    placeholder="••••••••">
                @error('password')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                <label for="remember" class="ml-2 text-sm text-slate-600">Remember me</label>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white py-2.5 rounded-lg font-semibold hover:bg-slate-800 transition-colors shadow-lg shadow-slate-200">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>
