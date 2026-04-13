<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomItem extends Model
{
    use HasFactory;

    protected $fillable = ['bom_id', 'item_id', 'quantity'];

    // Relasi ke barang (komponen/bahan baku penyusun resep)
    public function item()
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }
}
