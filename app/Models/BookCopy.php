<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    // IZINKAN SEMUA KOLOM DIISI
    protected $guarded = []; 

    // Relasi ke Buku Induk
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}