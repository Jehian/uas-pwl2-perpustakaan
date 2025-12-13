<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Member; // Import model
use App\Models\Loan;   // Import model

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Member
        $totalMembers = Member::count();

        // 2. Hitung Peminjaman Berjalan (Statistik)
        $activeLoans = Loan::where('status', 'active')->count();
        
        // 3. Ambil 5 Peminjaman Terbaru yang SEDANG BERJALAN (Belum dikembalikan)
        // Kita filter where('status', '!=', 'returned')
        $recentLoans = Loan::with(['member', 'bookCopy.book'])
                        ->where('status', '!=', 'returned') 
                        ->orderBy('due_date', 'asc') // Urutkan dari yang paling mendesak (tenggat waktu terdekat)
                        ->take(5)
                        ->get();

        return view('admin.dashboard', compact('totalMembers', 'activeLoans', 'recentLoans'));
    }
}