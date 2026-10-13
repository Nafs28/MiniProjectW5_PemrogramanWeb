<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory System') - Laravel P5</title>
    <!-- Tailwind CSS CDN for polished and responsive modern styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <header class="bg-indigo-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-bold tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-boxes-stacked text-indigo-400"></i>
                        <span>INVENTORY<span class="text-indigo-400">APP</span></span>
                    </span>
                    <span class="text-xs uppercase bg-indigo-800 px-2.5 py-1 rounded-full text-indigo-200 font-medium">Laravel MVC</span>
                </div>

                @auth
                <nav class="hidden md:flex space-x-1">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fa-solid fa-gauge-high mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('products.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fa-solid fa-box mr-1"></i> Produk
                    </a>
                    <a href="{{ route('stock.movement') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('stock.movement') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fa-solid fa-arrow-right-arrow-left mr-1"></i> Mutasi Stok
                    </a>
                    <a href="{{ route('stock.history') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('stock.history') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> Histori
                    </a>
                    <a href="{{ route('categories.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('categories.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fa-solid fa-tags mr-1"></i> Kategori
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('suppliers.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fa-solid fa-truck-field mr-1"></i> Supplier
                    </a>
                </nav>

                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-medium leading-none">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-indigo-300 mt-0.5 capitalize">{{ Auth::user()->role }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-xs px-3 py-2 rounded-md transition font-semibold flex items-center gap-1.5">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        <!-- Reusable Alert Notification -->
        @if(session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if(session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">
                <div class="flex items-center gap-2 font-semibold mb-1">
                    <i class="fa-solid fa-triangle-exclamation"></i> Terjadi Kesalahan Validasi:
                </div>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            Inventory Management System &bull; Praktikum Web Pertemuan 5 &bull; Migrasi Laravel 11 MVC
        </div>
    </footer>

</body>
</html>
