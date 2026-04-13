<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'reference_number', 'sale_date', 'item_id', 'quantity', 'price_per_unit', 'total_amount', 'user_id', 'notes',
        'client_id', 'payment_status', 'delivery_status'
    ];

    public function item() { return $this->belongsTo(Item::class)->withTrashed(); }
    public function user() { return $this->belongsTo(User::class)->withTrashed(); }
    public function client() { return $this->belongsTo(Client::class)->withTrashed(); }

    // Otomatis kurangi stok gudang (OUT) barang jadi saat tercatat
    protected static function booted()
    {
        static::created(function ($sale) {
            InventoryTransaction::create([
                'item_id' => $sale->item_id,
                'user_id' => $sale->user_id,
                'type' => 'OUT', // Penjualan berarti barang keluar
                'qty' => $sale->quantity,
                'transaction_date' => $sale->sale_date,
                'reference_number' => 'INV-' . $sale->reference_number,
                'notes' => 'Penjualan: ' . $sale->notes
            ]);
        });

        // JIKA DIEDIT: Hapus riwayat gudang & kas lama untuk simulasi Undo (Rollback)
        static::updating(function ($sale) {
            InventoryTransaction::where('reference_number', 'INV-' . $sale->getOriginal('reference_number'))->get()->each->delete();
        });

        // Bikin riwayat gudang baru sesuai input Edit terbaru
        static::updated(function ($sale) {
            InventoryTransaction::create([
                'item_id' => $sale->item_id,
                'user_id' => $sale->user_id,
                'type' => 'OUT',
                'qty' => $sale->quantity,
                'transaction_date' => $sale->sale_date,
                'reference_number' => 'INV-' . $sale->reference_number,
                'notes' => 'Koreksi/Edit Penjualan: ' . $sale->notes
            ]);
        });

        static::deleting(function ($sale) {
            InventoryTransaction::where('reference_number', 'INV-' . $sale->reference_number)->get()->each->delete();
        });
    }
}
