<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('boms', function (Blueprint $table) {
            $table->id();
            // Produk jadi yang akan dibuat
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->string('name'); // Contoh: "Formula Air Dus 600ml Standar"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('boms');
    }
};
