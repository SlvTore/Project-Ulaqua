<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    protected $fillable = ['item_id', 'views'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
