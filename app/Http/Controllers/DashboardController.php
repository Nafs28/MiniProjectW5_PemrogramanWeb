<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ringkasan Metrik
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalInventoryValue = Product::select(DB::raw('SUM(stock * price) as total_value'))->value('total_value') ?? 0;

        // 2. Transaksi Mutasi
        $totalItemsIn = StockMovement::where('type', 'IN')->sum('quantity');
        $totalItemsOut = StockMovement::where('type', 'OUT')->sum('quantity');

        // 3. Produk Stok Rendah (stock <= minimum_stock)
        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        // 4. Laporan Agregat per Kategori
        $categoryReport = Category::withCount('products')
            ->withSum('products', 'stock')
            ->get();

        // 5. Transaksi Terbaru
        $recentMovements = StockMovement::with(['product', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalInventoryValue',
            'totalItemsIn',
            'totalItemsOut',
            'lowStockProducts',
            'categoryReport',
            'recentMovements'
        ));
    }
}
