@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
    <div class="mb-6 pb-4 border-b border-slate-100">
        <h1 class="text-2xl font-bold text-slate-900">Tambah Produk Baru</h1>
        <p class="text-sm text-slate-500">Lengkapi formulir di bawah ini untuk mendaftarkan produk ke sistem</p>
    </div>

    <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="sku" class="block text-sm font-medium text-slate-700 mb-1">SKU (Kode Unik) *</label>
                <input type="text" id="sku" name="sku" value="{{ old('sku') }}" placeholder="Contoh: SKU-001" required
                       class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">Kategori *</label>
                <select id="category_id" name="category_id" required
                        class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Produk *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama barang" required
                   class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="price" class="block text-sm font-medium text-slate-700 mb-1">Harga Satuan (Rp) *</label>
                <input type="number" id="price" name="price" value="{{ old('price', 0) }}" min="0" step="100" required
                       class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-slate-700 mb-1">Stok Awal *</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" required
                       class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label for="minimum_stock" class="block text-sm font-medium text-slate-700 mb-1">Batas Stok Rendah *</label>
                <input type="number" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', 5) }}" min="0" required
                       class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Hubungkan Supplier (Many-to-Many)</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3 bg-slate-50 border border-slate-200 rounded-lg max-h-40 overflow-y-auto">
                @foreach($suppliers as $supplier)
                    <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                        <input type="checkbox" name="suppliers[]" value="{{ $supplier->id }}"
                               {{ is_array(old('suppliers')) && in_array($supplier->id, old('suppliers')) ? 'checked' : '' }}
                               class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span>{{ $supplier->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Keterangan / Spesifikasi</label>
            <textarea id="description" name="description" rows="3"
                      class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
            <a href="{{ route('products.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg text-sm shadow-sm transition">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Produk
            </button>
        </div>
    </form>
</div>
@endsection
