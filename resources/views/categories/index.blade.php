@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm md:col-span-1">
        <h2 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Tambah Kategori Baru</h2>
        <form method="POST" action="{{ route('categories.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori *</label>
                <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition">
                Simpan Kategori
            </button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm md:col-span-2">
        <h2 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Daftar Kategori</h2>
        <div class="divide-y divide-slate-100">
            @foreach($categories as $category)
            <div class="py-3 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-slate-900">{{ $category->name }}</h3>
                    <p class="text-xs text-slate-500">{{ $category->description ?: 'Tidak ada deskripsi' }}</p>
                    <span class="text-xs text-indigo-600 font-medium">{{ $category->products_count }} Produk</span>
                </div>
                <div>
                    @if($category->products_count === 0)
                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:text-rose-900 text-xs font-semibold">Hapus</button>
                    </form>
                    @else
                    <span class="text-xs text-slate-400">Terkait Produk</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
