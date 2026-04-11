<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'short_name'];

    // Relasi: Satu Satuan/Unit dipakai oleh banyak Items
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
