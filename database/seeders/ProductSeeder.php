<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan Kategori Produk Jadi ada, jika belum buat baru
        $category = Category::firstOrCreate(
            ['name' => 'Produk Jadi'],
            ['description' => 'Produk Hasil Produksi Siap Jual']
        );

        // Pastikan Satuan Kardus/Dus ada, jika belum buat baru
        $unit = Unit::firstOrCreate(
            ['name' => 'Kardus'],
            ['short_name' => 'Dus']
        );

        // Gunakan updateOrCreate agar seeder ini bersifat Idempotent (aman dijalankan berulang kali)
        Item::updateOrCreate(
            ['sku' => 'BAM-2L-3B'],
            [
                'name'           => 'Botol Air Mineral 2L (3 Botol)',
                'category_id'    => $category->id,
                'unit_id'        => $unit->id,
                'min_alert'      => 5,
                'expected_stock' => 50,
                'default_price'  => 70000,
                'is_active'      => true,
            ]
        );

        Item::updateOrCreate(
            ['sku' => 'BAM-3L-3B'],
            [
                'name'           => 'Botol Air Mineral 3L (3 Botol)',
                'category_id'    => $category->id,
                'unit_id'        => $unit->id,
                'min_alert'      => 5,
                'expected_stock' => 0, // Stok Habis
                'default_price'  => 60000,
                'is_active'      => true,
            ]
        );

        Item::updateOrCreate(
            ['sku' => 'BAM-3L-2B'],
            [
                'name'           => 'Botol Air Mineral 3L (2 Botol)',
                'category_id'    => $category->id,
                'unit_id'        => $unit->id,
                'min_alert'      => 5,
                'expected_stock' => 15,
                'default_price'  => 55000,
                'is_active'      => true,
            ]
        );
    }
}
