@extends('layouts.app')

@section('title', 'Mutasi Stok')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
    <div class="mb-6 pb-4 border-b border-slate-100">
        <h1 class="text-2xl font-bold text-slate-900">Pencatatan Mutasi Stok</h1>
        <p class="text-sm text-slate-500">Mencatat barang masuk atau barang keluar dengan proteksi transaksi database</p>
    </div>

    <form method="POST" action="{{ route('stock.movement.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="product_id" class="block text-sm font-medium text-slate-700 mb-1">Pilih Produk *</label>
            <select id="product_id" name="product_id" required
                    class="w-full px-3.5 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                <option value="">-- Pilih Produk --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->name }} (SKU: {{ $p->sku }} &bull; Sisa Stok: {{ $p->stock }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Transaksi *</label>
            <div class="grid grid-cols-2 gap-4">
                <label class="flex items-center gap-3 p-3 border border-slate-300 rounded-lg cursor-pointer hover:bg-slate-50">
                    <input type="radio" name="type" value="IN" {{ old('type', 'IN') == 'IN' ? 'checked' : '' }}
                           class="text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <div class="text-sm font-semibold text-emerald-700">Barang Masuk (IN)</div>
                        <div class="text-xs text-slate-500">Menambah stok persediaan</div>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3 border border-slate-300 rounded-lg cursor-pointer hover:bg-slate-50">
                    <input type="radio" name="type" value="OUT" {{ old('type') == 'OUT' ? 'checked' : '' }}
                           class="text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <div class="text-sm font-semibold text-rose-700">Barang Keluar (OUT)</div>
                        <div class="text-xs text-slate-500">Mengurangi stok persediaan</div>
                    </div>
                </label>
            </div>
        </div>

        <div>
            <label for="quantity" class="block text-sm font-medium text-slate-700 mb-1">Jumlah Unit (Quantity) *</label>
            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required
                   class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            <span class="text-xs text-slate-400 mt-1 block">Jumlah harus lebih besar dari 0. Sistem menolak barang keluar melebihi stok yang ada.</span>
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">Catatan / Alasan Transaksi</label>
            <input type="text" id="notes" name="notes" value="{{ old('notes') }}" placeholder="Contoh: Penerimaan supplier #PO-2026 atau Penjualan kasir"
                   class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
        </div>

        <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg text-sm shadow-sm transition">
                <i class="fa-solid fa-arrow-right-arrow-left mr-1"></i> Proses Mutasi
            </button>
        </div>
    </form>
</div>
@endsection
