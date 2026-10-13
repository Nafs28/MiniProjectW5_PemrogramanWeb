@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('products.index') }}" class="text-xs text-indigo-600 hover:underline inline-flex items-center gap-1 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Produk
            </a>
            <h1 class="text-2xl font-bold text-slate-900">{{ $product->name }}</h1>
            <p class="text-sm font-mono text-slate-500">SKU: {{ $product->sku }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('products.edit', $product) }}" class="bg-amber-600 hover:bg-amber-700 text-white text-sm px-3.5 py-2 rounded-lg font-medium transition">
                Edit Produk
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm md:col-span-2 space-y-4">
            <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-2">Informasi Produk</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-slate-500 block text-xs">Kategori</span>
                    <span class="font-semibold text-slate-800">{{ $product->category->name }}</span>
                </div>
                <div>
                    <span class="text-slate-500 block text-xs">Harga Satuan</span>
                    <span class="font-semibold text-slate-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="text-slate-500 block text-xs">Stok Tersedia</span>
                    <span class="font-bold text-lg {{ $product->stock <= $product->minimum_stock ? 'text-rose-600' : 'text-emerald-600' }}">
                        {{ $product->stock }} unit
                    </span>
                </div>
                <div>
                    <span class="text-slate-500 block text-xs">Ambang Batas Minimum</span>
                    <span class="font-semibold text-slate-800">{{ $product->minimum_stock }} unit</span>
                </div>
            </div>

            <div>
                <span class="text-slate-500 block text-xs mb-1">Deskripsi</span>
                <p class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>
            </div>

            <div>
                <span class="text-slate-500 block text-xs mb-1">Supplier Terkait</span>
                <div class="flex flex-wrap gap-2">
                    @forelse($product->suppliers as $sup)
                        <span class="bg-indigo-50 text-indigo-700 text-xs px-2.5 py-1 rounded-full border border-indigo-200">
                            {{ $sup->name }}
                        </span>
                    @empty
                        <span class="text-xs text-slate-400">Belum ada supplier yang ditautkan.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
            <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-2">Aksi Cepat</h2>
            <a href="{{ route('stock.movement') }}" class="w-full block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg text-sm transition">
                <i class="fa-solid fa-plus-minus mr-1"></i> Catat Mutasi
            </a>
            <p class="text-xs text-slate-500 leading-relaxed">
                Stok dikelola melalui fitur mutasi transaksi untuk menjamin konsistensi audit persediaan.
            </p>
        </div>
    </div>
</div>
@endsection
