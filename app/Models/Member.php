<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = []; // Ini sudah aman

    // Pastikan relasi ke Loan ada (untuk pengecekan history)
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}