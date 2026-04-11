<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'name'];

    // Relasi ke Produk Jadi
    public function product()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    // Relasi ke detail komponen bahan baku
    public function components()
    {
        return $this->hasMany(BomItem::class);
    }
}
