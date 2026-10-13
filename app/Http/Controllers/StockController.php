<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Tampilkan form transaksi mutasi stok (IN / OUT).
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.movement', compact('products'));
    }

    /**
     * Simpan mutasi stok dengan Database Transaction & Pessimistic Locking.
     * Business rules:
     * 1. Qty > 0
     * 2. Jika OUT, qty <= stok tersedia. Stok tidak boleh negatif!
     * 3. DB Transaction: update tabel products dan insert ke stock_movements secara atomik.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:IN,OUT'],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Lock the product row for update to prevent race conditions
                $product = Product::where('id', $validated['product_id'])->lockForUpdate()->first();

                if ($validated['type'] === 'OUT') {
                    if ($product->stock < $validated['quantity']) {
                        throw new \Exception("Stok tidak mencukupi! Stok saat ini: {$product->stock}, permintaan keluar: {$validated['quantity']}.");
                    }
                    $product->stock -= $validated['quantity'];
                } else {
                    $product->stock += $validated['quantity'];
                }

                $product->save();

                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id() ?? 1,
                    'type' => $validated['type'],
                    'quantity' => $validated['quantity'],
                    'notes' => $validated['notes'],
                ]);
            });

            $typeLabel = $validated['type'] === 'IN' ? 'Barang Masuk' : 'Barang Keluar';
            return redirect()->route('stock.history')
                ->with('success', "Transaksi {$typeLabel} berhasil disimpan!");

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Tampilkan riwayat mutasi stok.
     */
    public function history(Request $request)
    {
        $query = StockMovement::with(['product.category', 'user'])->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->query('type'));
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->query('product_id'));
        }

        $movements = $query->paginate(15)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('stock.history', compact('movements', 'products'));
    }
}
