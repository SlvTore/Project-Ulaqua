<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'item_id', 'user_id', 'type', 'qty', 'reference_number', 'notes', 'transaction_date'
    ];

    // Relasi ke Barang
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi ke Staf/Pembuat Catatan
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // -----------------------------------------------------
    // SISTEM OTOMATIS (EVENTS): Memperbarui Stok secara Real-Time
    // -----------------------------------------------------
    protected static function booted()
    {
        // Fungsi ini akan dieksekusi secara otomatis setiap model ini di "Create" (disimpan)
        static::created(function ($transaction) {
            $item = $transaction->item;

            if ($transaction->type === 'IN') {
                // Barang masuk, stok bertambah
                $item->expected_stock += $transaction->qty;
            } elseif ($transaction->type === 'OUT') {
                // Barang keluar, stok berkurang
                $item->expected_stock -= $transaction->qty;
            }

            $item->save(); // Simpan master barang terbaru
        });
    }
}
