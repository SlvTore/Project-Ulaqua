<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    // Relasi: Satu Kategori punya banyak Items
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
