<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     * Ditambahkan 'role' untuk mendukung sistem backend admin.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'role',      // Tambahan: Untuk membedakan Admin dan User biasa
        'google_id', // Mendukung login Google
        'apple_id',  // Mendukung login Apple
        'avatar',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data tertentu (Casts).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Helper untuk mendapatkan nama lengkap secara otomatis.
     * Dapat diakses dengan $user->full_name
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Helper untuk mengecek apakah user adalah admin.
     * Berguna untuk pengecekan cepat di Blade: @if(auth()->user()->isAdmin())
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}