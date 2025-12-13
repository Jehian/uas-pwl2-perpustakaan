<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Member;
use App\Models\BookCopy;
use Illuminate\Http\Request;
use Carbon\Carbon; // Untuk tanggal

class LoanController extends Controller
{
    // 1. DAFTAR PEMINJAMAN
   public function index(Request $request)
    {
        // 1. Siapkan Query Dasar
        $query = Loan::with(['member', 'bookCopy.book']);

        // 2. Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                // Cari berdasarkan Nama Member
                $q->whereHas('member', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                // ATAU Cari berdasarkan Kode Fisik Buku
                ->orWhereHas('bookCopy', function($q) use ($search) {
                    $q->where('copy_code', 'like', '%' . $search . '%')
                      // ATAU Cari berdasarkan Judul Buku
                      ->orWhereHas('book', function($q) use ($search) {
                          $q->where('title', 'like', '%' . $search . '%');
                      });
                });
            });
        }

        // 3. Ambil data dengan Pagination
        $loans = $query->latest()->paginate(7); 
                     
        return view('admin.loans.index', compact('loans'));
    }

    // 2. FORM TAMBAH PEMINJAMAN
    public function create()
    {
        // Ambil member aktif
        $members = Member::where('is_active', 1)->get();
        
        // Ambil HANYA buku yang statusnya 'available' (Tersedia)
        // Kita gabungkan Judul + Kode Fisik agar admin mudah memilih
        $copies = BookCopy::with('book')
                          ->where('status', 'available')
                          ->get();

        return view('admin.loans.create', compact('members', 'copies'));
    }

    // 3. PROSES SIMPAN (TRANSAKSI)
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'book_copy_id' => 'required',
            'duration' => 'required|integer|min:1' // Berapa hari pinjam
        ]);

        $member = Member::find($request->member_id);
        if ($member && !$member->is_active) {
            return back()->with('error', 'Member ini sudah Non-Aktif dan tidak bisa meminjam buku!');
        }
    
        // Hitung Tanggal
        $loanDate = Carbon::now();
        // Tambahkan (int) di depannya
        $dueDate = Carbon::now()->addDays((int) $request->duration);

        // A. Simpan Data Peminjaman
        Loan::create([
            'member_id' => $request->member_id,
            'book_copy_id' => $request->book_copy_id,
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'status' => 'active'
        ]);

        // B. Update Status Buku Jadi 'Dipinjam'
        $copy = BookCopy::find($request->book_copy_id);
        $copy->update(['status' => 'borrowed']);

        return redirect()->route('admin.loans.index')
                         ->with('success', 'Buku berhasil dipinjamkan!');
    }

    // 4. PROSES PENGEMBALIAN BUKU
    public function complete($id)
    {
        $loan = Loan::findOrFail($id);
        
        if ($loan->status == 'returned') {
            return back()->with('error', 'Buku ini sudah dikembalikan!');
        }

        // 1. Hitung Denda
        $fineAmount = 0;
        $dateNow = Carbon::now();
        $dueDate = Carbon::parse($loan->due_date);

        // Jika hari ini LEBIH BESAR dari jatuh tempo (Terlambat)
       if ($dateNow->gt($dueDate)) {
            $lateDays = $dateNow->diffInDays($dueDate); 
            
            // UBAH DARI 1000 JADI 10000 DI SINI JUGA
            $fineAmount = $lateDays * 10000; 
        }

        // 2. Update Data Peminjaman
        $loan->update([
            'return_date' => $dateNow,
            'status' => 'returned',
            'fine_amount' => $fineAmount // Simpan denda
        ]);

        // 3. Kembalikan Stok Buku
        $loan->bookCopy->update([
            'status' => 'available'
        ]);
        
        // Buat pesan notifikasi yang beda kalau ada denda
        if ($fineAmount > 0) {
            return redirect()->back()
                ->with('warning', 'Buku dikembalikan. Terlambat ' . $lateDays . ' hari. Denda: Rp ' . number_format($fineAmount));
        }

        return redirect()->back()
            ->with('success', 'Buku berhasil dikembalikan tepat waktu!');
    }

    // 5. PERPANJANG / UBAH TANGGAL JATUH TEMPO
    public function updateDueDate(Request $request, $id)
    {
        $request->validate([
            // HAPUS '|after_or_equal:today' AGAR BISA PILIH TANGGAL MUNDUR
            'due_date' => 'required|date', 
        ]);

        $loan = Loan::findOrFail($id);
        
        $loan->update([
            'due_date' => $request->due_date
        ]);

        return back()->with('success', 'Tanggal jatuh tempo berhasil diperbarui!');
    }

    // --- HAPUS TRANSAKSI PEMINJAMAN ---
    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);

        // Logika Keamanan:
        // Jika data dihapus saat buku masih dipinjam, kembalikan status buku jadi 'Tersedia'
        if ($loan->status == 'active') {
            $loan->bookCopy->update(['status' => 'available']);
        }

        $loan->delete();

        return back()->with('success', 'Riwayat peminjaman berhasil dihapus!');
    }

}