<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bom_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_id')->constrained('boms')->onDelete('cascade');
            // Bahan baku yang dibutuhkan
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            // Jumlah bahan baku yang dibutuhkan untuk 1 unit produk jadi
            $table->decimal('quantity', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bom_items');
    }
};
