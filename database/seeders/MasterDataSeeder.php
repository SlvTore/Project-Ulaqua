<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Unit;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kategori Dasar
        Category::create(['name' => 'Produk Jadi', 'description' => 'Produk Hasil Produksi Siap Jual']);
        Category::create(['name' => 'Bahan Baku', 'description' => 'Material Dasar Produksi']);
        Category::create(['name' => 'Kemasan', 'description' => 'Material Pendukung & Packaging']);

        // 2. Buat Satuan Dasar
        Unit::create(['name' => 'Pieces', 'short_name' => 'Pcs']);
        Unit::create(['name' => 'Kardus', 'short_name' => 'Dus']);
        Unit::create(['name' => 'Galon', 'short_name' => 'Gln']);
        Unit::create(['name' => 'Bal', 'short_name' => 'Bal']);
        Unit::create(['name' => 'Roll', 'short_name' => 'Roll']);

        // *Tidak ada lagi Item (Barang) yang dibuat di sini.
        // User akan memulainya dari kanvas kosong!*
    }
}
