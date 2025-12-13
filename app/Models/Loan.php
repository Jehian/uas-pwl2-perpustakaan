<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // <--- Pastikan Import Carbon

class Loan extends Model
{
    protected $guarded = [];

    // Relasi (Biarkan yang sudah ada)
    public function member() { return $this->belongsTo(Member::class); }
    public function bookCopy() { return $this->belongsTo(BookCopy::class); }

    // --- TAMBAHKAN KODE DI BAWAH INI ---

    // Fitur: Hitung Denda Otomatis (Accessor)
    // Cara panggil di view: $loan->calculated_denda
    public function getCalculatedDendaAttribute()
    {
        if ($this->status == 'returned') {
            return $this->fine_amount;
        }

        $now = Carbon::now()->startOfDay();
        $dueDate = Carbon::parse($this->due_date)->startOfDay();

        if ($now->gt($dueDate)) {
            $lateDays = $now->diffInDays($dueDate);
            
            // UBAH DARI 1000 JADI 10000 DI SINI
            return $lateDays * 10000; 
        }

        return 0;
    }
}