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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();     // Kode Produksi: PRD-202xxx
            $table->date('production_date');                  // Tanggal dibuatnya barang
            $table->foreignId('item_id')->constrained('items'); // Produk Jadi yang dihasilkan (Air Cup/Galon)
            $table->foreignId('bom_id')->nullable()->constrained('boms')->nullOnDelete(); // Dicatat memakai Resep apa
            $table->decimal('quantity', 10, 2);               // Jumlah diproduksi
            $table->decimal('total_cost', 15, 2)->default(0); // Total Biaya modal yang dihabiskan untuk batch ini
            $table->foreignId('user_id')->constrained('users'); // Siapa yang mencatat
            $table->text('notes')->nullable();                // Catatan opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
