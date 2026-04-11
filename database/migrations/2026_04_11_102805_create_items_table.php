<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique()->nullable(); // Kode barcode / kode unik item
            $table->string('name'); // Nama Item: 'Botol 600ml Kosong'
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->foreignId('unit_id')->constrained('units')->onDelete('restrict');

            // Pengaturan Batas Stok
            $table->integer('min_alert')->default(0); // Batas alert stok kritis (Low Stock)
            $table->integer('expected_stock')->default(0); // Saldo bayangan / real-time stock

            // Harga (Bisa untuk penjualan / estimasi HPP per item)
            $table->decimal('default_price', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
