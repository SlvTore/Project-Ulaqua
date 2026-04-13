<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Tambahkan baris ini

class Item extends Model
{
    use SoftDeletes; // 2. Tambahkan ini di atas 'protected $fillable'

    protected $fillable = [
        'name', 'sku', 'category_id', 'unit_id', 'min_alert', 'expected_stock', 'default_price', 'is_active'
    ];

    // Relasi Balik: Item ini masuk ke Kategori mana?
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi Balik: Item ini pakai Satuan apa (Dus/Pcs)?
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Relasi: Item ini memiliki BOM
    public function boms()
    {
        return $this->hasMany(Bom::class, 'item_id');
    }
}
