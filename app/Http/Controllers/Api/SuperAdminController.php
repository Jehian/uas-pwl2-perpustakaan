<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan ini Model untuk Admin Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    // 1. LIHAT SEMUA ADMIN (Untuk cek ID admin yang lupa password)
    public function index()
    {
        $admins = User::select('id', 'name', 'email', 'created_at')->get();

        return response()->json([
            'status' => 'success',
            'data' => $admins
        ]);
    }

    // 2. RESET PASSWORD ADMIN
    public function resetPassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:6'
        ]);

        // Cari admin berdasarkan email
        $admin = User::where('email', $request->email)->first();

        if (!$admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Admin dengan email tersebut tidak ditemukan.'
            ], 404);
        }

        // Update password
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil direset! Silakan login dengan password baru.',
            'target_admin' => $admin->name
        ]);
    }
}