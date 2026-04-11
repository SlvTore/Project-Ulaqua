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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('item_id')->constrained('items')->onDelete('restrict');
            // Mengetahui staf siapa yang menginput data ini
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');

            // Jenis transaksi: 'IN' (Masuk), 'OUT' (Keluar)
            $table->enum('type', ['IN', 'OUT']);

            // Jumlah barang yang masuk/keluar
            $table->integer('qty');

            // Catatan atau Nomor Surat Jalan/Faktur (Opsional)
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();

            // Tanggal transaksi (berguna jika input data mundur)
            $table->date('transaction_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
