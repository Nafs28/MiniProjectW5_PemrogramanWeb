@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Produk</h1>
            <p class="text-sm text-slate-500">Kelola katalog produk, SKU, kategori, dan harga</p>
        </div>
        <div>
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium shadow-sm transition">
                <i class="fa-solid fa-plus"></i> Tambah Produk Baru
            </a>
        </div>
    </div>

    <!-- Filter, Search, and Sort Panel -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Pencarian</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau SKU..."
                           class="w-full pl-9 pr-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-sm"></i>
                </div>
            </div>

            <!-- Filter Category -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Filter Kategori</label>
                <select name="category_id" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Urutkan Berdasarkan</label>
                <select name="sort" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>Nama Produk</option>
                    <option value="price" {{ $sort == 'price' ? 'selected' : '' }}>Harga</option>
                    <option value="stock" {{ $sort == 'stock' ? 'selected' : '' }}>Stok</option>
                    <option value="sku" {{ $sort == 'sku' ? 'selected' : '' }}>SKU</option>
                    <option value="created_at" {{ $sort == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-slate-800 hover:bg-slate-900 text-white py-2 px-3 rounded-lg text-sm font-semibold transition">
                    <i class="fa-solid fa-filter mr-1"></i> Terapkan
                </button>
                <a href="{{ route('products.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 py-2 px-3 rounded-lg text-sm font-semibold transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                        <th class="py-3.5 px-4">SKU</th>
                        <th class="py-3.5 px-4">Nama Produk</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Harga Satuan</th>
                        <th class="py-3.5 px-4 text-center">Stok</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/75 transition">
                        <td class="py-3 px-4 font-mono text-xs font-bold text-indigo-700">{{ $product->sku }}</td>
                        <td class="py-3 px-4">
                            <div class="font-medium text-slate-900">{{ $product->name }}</div>
                            @if($product->suppliers->isNotEmpty())
                                <div class="text-xs text-slate-400 mt-0.5">Supplier: {{ $product->suppliers->pluck('name')->join(', ') }}</div>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-block bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-semibold text-slate-800">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if($product->stock <= $product->minimum_stock)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                    {{ $product->stock }} (Rendah)
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                    {{ $product->stock }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs">
                                Detail
                            </a>
                            <a href="{{ route('products.edit', $product) }}" class="text-amber-600 hover:text-amber-900 font-semibold text-xs">
                                Edit
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-900 font-semibold text-xs">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Tidak ada produk yang ditemukan sesuai kriteria filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        <div class="p-4 border-t border-slate-200">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
