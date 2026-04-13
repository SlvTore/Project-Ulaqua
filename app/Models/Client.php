<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_client', 'name', 'email', 'phone', 'address', 'photo', 'tag', 'latitude', 'longitude'
    ];

    // Status Appends agar selalu terbaca saat memanggil $client->status
    protected $appends = ['status'];

    // 1. Generator Otomatis untuk kode_client
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($client) {
            $latestClient = self::withTrashed()->latest('id')->first();
            $nextId = $latestClient ? $latestClient->id + 1 : 1;
            $client->kode_client = 'CL-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        });
    }

    // Relasi dengan Sales / Penjualan
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // 2. Status Dinamis (Lebih dari 6 bulan = Non Aktif)
    public function getStatusAttribute()
    {
        // Logika menggunakan relasi 'sales'
        $lastOrder = $this->sales()->latest('sale_date')->first();
        $lastActivityDate = $lastOrder ? Carbon::parse($lastOrder->sale_date) : ($this->created_at ?? Carbon::now());

        $monthsInactive = Carbon::now()->diffInMonths($lastActivityDate);

        return $monthsInactive >= 6 ? 'inactive' : 'active';
    }
}
