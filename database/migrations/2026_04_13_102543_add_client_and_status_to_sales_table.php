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
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('id');
            $table->string('payment_status')->default('Lunas')->after('notes'); // Lunas, Belum Lunas, Termin, Jatuh Tempo
            $table->string('delivery_status')->default('Selesai')->after('payment_status'); // Diproses, Dikirim, Selesai

            // Tambah relasi ke clients (opsional, karena model sudah has SoftDeletes, nullOnDelete bisa digunakan jika database direlasikan fisik)
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn(['client_id', 'payment_status', 'delivery_status']);
        });
    }
};
