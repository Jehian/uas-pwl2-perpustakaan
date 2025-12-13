<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail; // <--- PENTING: Untuk fitur email
use App\Mail\WelcomeEmail; // <--- PENTING: Class Email yang sudah kamu buat

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    // --- FUNGSI STORE (SIMPAN MEMBER BARU) ---
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. AUTO-GENERATE ID MEMBER (Format: MEM-0001)
        $lastMember = Member::orderBy('id', 'desc')->first();
        
        if ($lastMember) {
            // Ambil angka dari kode terakhir (MEM-0005 -> ambil 5)
            // Asumsi format MEM-XXXX (4 digit angka)
            // substr($string, 4) membuang "MEM-"
            $lastNumber = (int)substr($lastMember->member_code, 4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Generate kode baru: MEM-0001
        $memberCode = 'MEM-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // 3. SIAPKAN DATA
        $data = $request->all();
        $data['member_code'] = $memberCode; 
        $data['is_active'] = true; // Default aktif saat daftar baru

        // 4. UPLOAD FOTO (Jika Ada)
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('member-photos', 'public');
            $data['photo'] = $photoPath;
        }

        // 5. SIMPAN KE DATABASE
        $member = Member::create($data); // Tampung ke variabel $member agar bisa dipakai buat email

        // --- 6. KIRIM WELCOME EMAIL ---
        if ($member->email) {
            try {
                Mail::to($member->email)->send(new WelcomeEmail($member));
            } catch (\Exception $e) {
                // Log error jika gagal kirim, tapi jangan stop proses simpan data
                \Log::error("Gagal kirim welcome email ke " . $member->email . ": " . $e->getMessage());
            }
        }
        // -----------------------------

        return redirect()->route('admin.members.index')
                         ->with('success', 'Member berhasil ditambahkan! ID: ' . $memberCode);
    }

    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    // --- FUNGSI UPDATE (EDIT DATA) ---
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Logika Update Foto
        if ($request->hasFile('photo')) {
            // 1. Hapus foto lama jika ada
            if ($member->photo && Storage::disk('public')->exists($member->photo)) {
                Storage::disk('public')->delete($member->photo);
            }
            
            // 2. Upload foto baru
            $photoPath = $request->file('photo')->store('member-photos', 'public');
            $data['photo'] = $photoPath;
        }

        $member->update($data);

        return redirect()->route('admin.members.index')
                         ->with('success', 'Data member berhasil diperbarui!');
    }

    // --- FUNGSI DESTROY (HAPUS PERMANEN) ---
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        try {
            // 1. Hapus Foto dari Storage (Jika ada)
            if ($member->photo && Storage::disk('public')->exists($member->photo)) {
                Storage::disk('public')->delete($member->photo);
            }

            // 2. Hapus Data Permanen dari Database
            $member->delete();

            return redirect()->route('admin.members.index')
                             ->with('success', 'Data member berhasil dihapus permanen.');

        } catch (\Illuminate\Database\QueryException $e) {
            // 3. Error Handling: Jika gagal hapus (misal karena masih ada relasi dengan tabel loans)
            return back()->with('error', 'Gagal menghapus! Member ini memiliki riwayat peminjaman. Silakan Non-Aktifkan saja lewat menu Edit.');
        }
    }

    // --- FUNGSI UPDATE STATUS (NON-AKTIFKAN/AKTIFKAN) ---
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $member = Member::findOrFail($id);
        
        $member->update([
            'is_active' => $request->is_active
        ]);

        $statusText = $request->is_active ? 'Aktif' : 'Non-Aktif';

        return back()->with('success', "Status member berhasil diubah menjadi: $statusText");
    }
}