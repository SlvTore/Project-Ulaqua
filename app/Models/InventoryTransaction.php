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
        return $this->belongsTo(Item::class)->withTrashed();
    }

    // Relasi ke Staf/Pembuat Catatan
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    // -----------------------------------------------------
    // SISTEM OTOMATIS (EVENTS): Memperbarui Stok secara Real-Time
    // -----------------------------------------------------
    protected static function booted()
    {
        // Fungsi ini akan dieksekusi secara otomatis setiap model ini di "Create" (disimpan)
        static::created(function ($transaction) {
            $item = \App\Models\Item::find($transaction->item_id);
            if ($item) {
                if ($transaction->type === 'IN') {
                    $item->expected_stock += $transaction->qty;
                } elseif ($transaction->type === 'OUT') {
                    $item->expected_stock -= $transaction->qty;
                }
                $item->saveQuietly(); // Simpan tanpa mentrigger event lain
            }
        });

        // FUNGSI BARU CANGGIH: Jika tiket transaksi dihapus, stok MAJU-MUNDUR dikembalikan ke asal!
        static::deleted(function ($transaction) {
            $item = \App\Models\Item::find($transaction->item_id);
            if ($item) {
                if ($transaction->type === 'IN') {
                    $item->expected_stock -= $transaction->qty; // Revert IN
                } elseif ($transaction->type === 'OUT') {
                    $item->expected_stock += $transaction->qty; // Revert OUT
                }
                $item->saveQuietly();
            }
        });
    }
}
