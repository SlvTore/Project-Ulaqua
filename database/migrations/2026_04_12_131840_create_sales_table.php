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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->date('sale_date');
            $table->foreignId('item_id')->constrained('items'); // Barang Jadi yang dijual
            $table->decimal('quantity', 10, 2);
            $table->decimal('price_per_unit', 15, 2); // Harga jual satuan
            $table->decimal('total_amount', 15, 2); // Total pendapatan
            $table->foreignId('user_id')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
