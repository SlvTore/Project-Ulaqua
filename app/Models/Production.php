<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Production extends Model
{
    protected $fillable = [
        'reference_number', 'production_date', 'item_id', 'bom_id', 'quantity', 'total_cost', 'user_id', 'notes'
    ];

    public function item() { return $this->belongsTo(Item::class)->withTrashed(); }
    public function bom()  { return $this->belongsTo(Bom::class)->withTrashed(); }
    public function user() { return $this->belongsTo(User::class)->withTrashed(); }

    // FUNGSI BANTUAN TRIGGER IN/OUT GUDANG
    public function generateTransactions()
    {
        $this->load('bom.components');

        InventoryTransaction::create([
            'item_id' => $this->item_id,
            'user_id' => $this->user_id,
            'type' => 'IN',
            'qty' => $this->quantity,
            'transaction_date' => $this->production_date,
            'reference_number' => $this->reference_number,
            'notes' => "Hasil Produksi."
        ]);

        if ($this->bom && $this->bom->components) {
            foreach ($this->bom->components as $component) {
                $materialQtyNeeded = $component->quantity * $this->quantity;
                if ($materialQtyNeeded > 0) {
                    InventoryTransaction::create([
                        'item_id' => $component->item_id,
                        'user_id' => $this->user_id,
                        'type' => 'OUT',
                        'qty' => $materialQtyNeeded,
                        'transaction_date' => $this->production_date,
                        'reference_number' => $this->reference_number . '-RAW-' . $component->item_id,
                        'notes' => "Dikonsumsi untuk referensi Produksi: " . $this->reference_number
                    ]);
                }
            }
        }
    }

    protected static function booted()
    {
        static::created(function ($production) {
            $production->generateTransactions();
        });

        static::updating(function ($production) {
            InventoryTransaction::where('reference_number', 'like', $production->getOriginal('reference_number') . '%')->get()->each->delete();
        });

        static::updated(function ($production) {
            $production->generateTransactions();
        });

        static::deleting(function ($production) {
            InventoryTransaction::where('reference_number', 'like', $production->reference_number . '%')->get()->each->delete();
        });
    }
}
