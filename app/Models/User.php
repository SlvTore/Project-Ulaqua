<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambahkan
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'address', // <-- Tambahkan ini
        'phone',
        'gender',
        'dob',
        'degree',
        'designation',
        'about',
        'education',
        'experience',
        'avatar', // <-- Penting untuk foto
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Konfigurasi opsi logging otomatis
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user_activity') // <-- Ubah logName menjadi useLogName
            ->logFillable()    // Catat perubahan pada kolom fillable
            ->logOnlyDirty()   // Hanya catat yang berubah saja
            ->dontSubmitEmptyLogs();
    }

    /**
     * Accessor untuk mendapatkan URL Avatar dengan benar
     * Jika null, lemparkan gambar default (profile.png)
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && \Storage::disk('public')->exists('avatars/' . $this->avatar)) {
            return asset('storage/avatars/' . $this->avatar);
        }

        // Gambar default jika belum upload foto
        return asset('images/profile/profile.png');
    }
}
