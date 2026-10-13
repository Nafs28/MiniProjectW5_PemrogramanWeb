@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Inventaris</h1>
            <p class="text-sm text-slate-500">Ringkasan stok barang, nilai aset, dan transaksi terkini</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('stock.movement') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium shadow-sm transition">
                <i class="fa-solid fa-plus-minus"></i> Catat Mutasi Stok
            </a>
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium shadow-sm transition">
                <i class="fa-solid fa-plus"></i> Tambah Produk
            </a>
        </div>
    </div>

    <!-- 4 Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase">Total Produk</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($totalProducts) }}</h3>
                <p class="text-xs text-slate-400 mt-1">Dalam {{ $totalCategories }} kategori</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                <i class="fa-solid fa-box text-2xl"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase">Nilai Inventory</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-400 mt-1">Estimasi aset berjalan</p>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                <i class="fa-solid fa-coins text-2xl"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase">Total Barang Masuk</p>
                <h3 class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($totalItemsIn) }} <span class="text-sm font-normal text-slate-500">unit</span></h3>
                <p class="text-xs text-slate-400 mt-1">Akumulasi penerimaan</p>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                <i class="fa-solid fa-arrow-down-long text-2xl"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase">Total Barang Keluar</p>
                <h3 class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($totalItemsOut) }} <span class="text-sm font-normal text-slate-500">unit</span></h3>
                <p class="text-xs text-slate-400 mt-1">Akumulasi pengeluaran</p>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                <i class="fa-solid fa-arrow-up-long text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- 2 Column Layout: Low Stock & Category Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Low Stock Alert List -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> Peringatan Stok Rendah
                </h2>
                <span class="text-xs bg-rose-100 text-rose-700 font-semibold px-2.5 py-1 rounded-full">
                    {{ $lowStockProducts->count() }} Produk
                </span>
            </div>

            @if($lowStockProducts->isEmpty())
                <p class="text-sm text-slate-500 py-6 text-center">Semua stok produk berada di batas aman.</p>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($lowStockProducts as $p)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $p->name }}</p>
                                <p class="text-xs text-slate-400">SKU: {{ $p->sku }} &bull; {{ $p->category->name }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-2.5 py-0.5 rounded text-xs font-bold bg-rose-100 text-rose-700">
                                    Sisa: {{ $p->stock }} (Min: {{ $p->minimum_stock }})
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Category Aggregation Report -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-pie text-indigo-500"></i> Rekapitulasi per Kategori
            </h2>
            <div class="divide-y divide-slate-100">
                @foreach($categoryReport as $cat)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $cat->name }}</p>
                            <p class="text-xs text-slate-400">{{ $cat->products_count }} item produk terdaftar</p>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-slate-700">{{ number_format($cat->products_sum_stock ?? 0) }} unit</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
