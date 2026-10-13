<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\StockMovement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (Admin & Staff)
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@inventory.test',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $staff = User::firstOrCreate(
            ['username' => 'staff'],
            [
                'name' => 'Staff Gudang',
                'email' => 'staff@inventory.test',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
            ]
        );

        // 2. Seed Default Categories
        $categories = [
            ['name' => 'Elektronik & Gadget', 'description' => 'Barang elektronik dan periferal komputer'],
            ['name' => 'Alat Tulis Kantor', 'description' => 'Peralatan dan perlengkapan administrasi'],
            ['name' => 'Peralatan Jaringan', 'description' => 'Router, switch, kabel LAN, dan access point'],
            ['name' => 'Aksesoris Komputer', 'description' => 'Keyboard, mouse, flashdisk, dan kabel data'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = Category::firstOrCreate(['name' => $cat['name']], $cat);
        }

        // 3. Seed Suppliers
        $suppliers = [
            ['name' => 'PT Mitra Komputindo Nusantara', 'contact' => '081234567890', 'address' => 'Jl. Sudirman No. 45, Jakarta'],
            ['name' => 'CV Sumber Makmur Mandiri', 'contact' => '082198765432', 'address' => 'Jl. Gatot Subroto No. 12, Medan'],
            ['name' => 'PT Techindo Distribusi', 'contact' => '085311223344', 'address' => 'Jl. Pemuda No. 88, Surabaya'],
        ];

        $supplierModels = [];
        foreach ($suppliers as $sup) {
            $supplierModels[] = Supplier::firstOrCreate(['name' => $sup['name']], $sup);
        }

        // 4. Seed Products
        $products = [
            [
                'category_id' => $categoryModels[3]->id,
                'sku' => 'SKU-KB-001',
                'name' => 'Mechanical Keyboard RGB TKL',
                'price' => 450000,
                'stock' => 15,
                'minimum_stock' => 5,
                'description' => 'Keyboard mekanikal switch biru dengan backlight RGB'
            ],
            [
                'category_id' => $categoryModels[3]->id,
                'sku' => 'SKU-MS-002',
                'name' => 'Wireless Gaming Mouse',
                'price' => 250000,
                'stock' => 3, // Low stock
                'minimum_stock' => 5,
                'description' => 'Mouse tanpa kabel sensitivitas 16000 DPI'
            ],
            [
                'category_id' => $categoryModels[0]->id,
                'sku' => 'SKU-MN-003',
                'name' => 'Monitor LED IPS 24 Inch',
                'price' => 1750000,
                'stock' => 8,
                'minimum_stock' => 3,
                'description' => 'Monitor 75Hz bezel-less'
            ],
            [
                'category_id' => $categoryModels[2]->id,
                'sku' => 'SKU-RT-004',
                'name' => 'Gigabit Dual Band Wi-Fi Router',
                'price' => 520000,
                'stock' => 20,
                'minimum_stock' => 5,
                'description' => 'Router AC1200 dengan 4 antena eksternal'
            ],
            [
                'category_id' => $categoryModels[1]->id,
                'sku' => 'SKU-PP-005',
                'name' => 'Kertas HVS A4 80gsm (1 Rim)',
                'price' => 55000,
                'stock' => 45,
                'minimum_stock' => 10,
                'description' => 'Kertas fotokopi dan cetak 500 lembar'
            ],
        ];

        foreach ($products as $prod) {
            $p = Product::firstOrCreate(['sku' => $prod['sku']], $prod);
            // Attach random supplier
            $p->suppliers()->syncWithoutDetaching([
                $supplierModels[array_rand($supplierModels)]->id => ['supplier_price' => $prod['price'] * 0.8]
            ]);

            // Initial stock movement
            StockMovement::firstOrCreate(
                [
                    'product_id' => $p->id,
                    'type' => 'IN',
                    'quantity' => $p->stock,
                    'notes' => 'Stok awal sistem'
                ],
                [
                    'user_id' => $admin->id
                ]
            );
        }
    }
}
