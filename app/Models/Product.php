<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     * Sesuaikan dengan kolom yang ada di database Anda.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'category',
        'is_new',
        'is_bestseller'
    ];

    /**
     * Casting tipe data kolom.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_new' => 'boolean',
        'is_bestseller' => 'boolean',
    ];
}