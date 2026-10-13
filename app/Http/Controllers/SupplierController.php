<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('products')->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'contact' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string']
        ]);

        Supplier::create($validated);
        return back()->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->products()->detach();
        $supplier->delete();
        return back()->with('success', 'Supplier berhasil dihapus.');
    }
}
