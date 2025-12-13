<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = []; // Izinkan semua kolom diisi (Cara paling cepat)

    // Relasi: Satu buku punya satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Satu buku punya banyak copy fisik
    public function copies()
    {
        return $this->hasMany(BookCopy::class);
    }
}