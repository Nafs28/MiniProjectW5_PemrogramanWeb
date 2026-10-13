@extends('layouts.app')

@section('title', 'Manajemen Supplier')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm md:col-span-1">
        <h2 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Tambah Supplier Baru</h2>
        <form method="POST" action="{{ route('suppliers.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Supplier *</label>
                <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label for="contact" class="block text-sm font-medium text-slate-700 mb-1">Kontak / No Telp</label>
                <input type="text" id="contact" name="contact" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
                <textarea id="address" name="address" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition">
                Simpan Supplier
            </button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm md:col-span-2">
        <h2 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Daftar Supplier</h2>
        <div class="divide-y divide-slate-100">
            @foreach($suppliers as $supplier)
            <div class="py-3 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-slate-900">{{ $supplier->name }}</h3>
                    <p class="text-xs text-slate-500">{{ $supplier->contact }} &bull; {{ $supplier->address }}</p>
                    <span class="text-xs text-indigo-600 font-medium">{{ $supplier->products_count }} Produk dipasok</span>
                </div>
                <div>
                    <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" onsubmit="return confirm('Hapus supplier ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:text-rose-900 text-xs font-semibold">Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
