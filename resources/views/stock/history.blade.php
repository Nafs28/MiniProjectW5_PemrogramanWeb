@extends('layouts.app')

@section('title', 'Histori Mutasi Stok')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Riwayat Mutasi Stok</h1>
            <p class="text-sm text-slate-500">Log transaksi keluar-masuk barang yang tercatat secara atomik</p>
        </div>
        <div>
            <a href="{{ route('stock.movement') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium shadow-sm transition">
                <i class="fa-solid fa-plus-minus"></i> Catat Mutasi Baru
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('stock.history') }}" class="flex flex-wrap items-center gap-4">
            <div class="w-48">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Filter Tipe</label>
                <select name="type" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    <option value="">Semua Mutasi</option>
                    <option value="IN" {{ request('type') == 'IN' ? 'selected' : '' }}>Barang Masuk (IN)</option>
                    <option value="OUT" {{ request('type') == 'OUT' ? 'selected' : '' }}>Barang Keluar (OUT)</option>
                </select>
            </div>

            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Pilih Produk</label>
                <select name="product_id" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    <option value="">Semua Produk</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->name }} ({{ $p->sku }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2 pt-5">
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white py-2 px-4 rounded-lg text-sm font-semibold transition">
                    Filter
                </button>
                <a href="{{ route('stock.history') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 py-2 px-3 rounded-lg text-sm font-semibold transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table History -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                        <th class="py-3.5 px-4">Waktu</th>
                        <th class="py-3.5 px-4">Produk</th>
                        <th class="py-3.5 px-4">Tipe Mutasi</th>
                        <th class="py-3.5 px-4 text-center">Jumlah</th>
                        <th class="py-3.5 px-4">Dicatat Oleh</th>
                        <th class="py-3.5 px-4">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($movements as $m)
                    <tr class="hover:bg-slate-50/75 transition">
                        <td class="py-3 px-4 text-xs text-slate-500 whitespace-nowrap">
                            {{ $m->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="py-3 px-4">
                            <span class="font-medium text-slate-900">{{ $m->product->name }}</span>
                            <span class="text-xs font-mono text-indigo-600 block">{{ $m->product->sku }}</span>
                        </td>
                        <td class="py-3 px-4">
                            @if($m->type === 'IN')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800">
                                    <i class="fa-solid fa-arrow-down text-[10px]"></i> MASUK (IN)
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-xs font-bold bg-rose-100 text-rose-800">
                                    <i class="fa-solid fa-arrow-up text-[10px]"></i> KELUAR (OUT)
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center font-bold text-slate-800">
                            {{ $m->type === 'IN' ? '+' : '-' }}{{ $m->quantity }}
                        </td>
                        <td class="py-3 px-4 text-xs text-slate-600">
                            {{ $m->user?->name ?? 'Sistem' }}
                        </td>
                        <td class="py-3 px-4 text-xs text-slate-500">
                            {{ $m->notes ?: '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Belum ada catatan riwayat transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200">
            {{ $movements->links() }}
        </div>
    </div>
</div>
@endsection
