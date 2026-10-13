@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto mt-12 bg-white p-8 rounded-xl shadow-lg border border-slate-200">
    <div class="text-center mb-8">
        <div class="inline-flex p-3 rounded-full bg-indigo-100 text-indigo-700 mb-3">
            <i class="fa-solid fa-lock text-2xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-slate-900">Masuk ke Sistem</h1>
        <p class="text-sm text-slate-500 mt-1">Silakan masukkan username dan password Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="username" class="block text-sm font-medium text-slate-700 mb-1">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                   class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <span class="text-slate-600">Ingat saya</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-md hover:shadow-lg transition">
            <i class="fa-solid fa-right-to-bracket mr-2"></i> Log In
        </button>
    </form>

    <div class="mt-6 pt-6 border-t border-slate-100 text-xs text-slate-500 text-center space-y-1">
        <p><strong>Akun Uji Coba:</strong></p>
        <p>Admin: <code class="bg-slate-100 px-1 py-0.5 rounded">admin</code> / <code class="bg-slate-100 px-1 py-0.5 rounded">admin123</code></p>
        <p>Staff: <code class="bg-slate-100 px-1 py-0.5 rounded">staff</code> / <code class="bg-slate-100 px-1 py-0.5 rounded">staff123</code></p>
    </div>
</div>
@endsection
