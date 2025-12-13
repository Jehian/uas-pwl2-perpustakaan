<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Http\Request;

class BookCopyController extends Controller
{
    // 1. Tampilkan Halaman Kelola Stok untuk Buku Tertentu
    public function index($book_id)
    {
        $book = Book::with('copies')->findOrFail($book_id);
        return view('admin.books.copies', compact('book'));
    }

    // 2. Tambah Stok Baru (Otomatis Generate Code)
    public function store(Request $request, $book_id)
    {
        $book = Book::findOrFail($book_id);

        // Hitung sudah ada berapa copy, lalu tambah 1 untuk urutan
        $count = $book->copies()->count();
        $nextNumber = $count + 1;

        // Format Kode: KODEBUKU-C1, KODEBUKU-C2
        $copyCode = $book->book_code . '-C' . $nextNumber;

        // Simpan
        BookCopy::create([
            'book_id' => $book->id,
            'copy_code' => $copyCode,
            'status' => 'available' // Default tersedia
        ]);

        return back()->with('success', 'Stok berhasil ditambahkan! Kode: ' . $copyCode);
    }

    // 3. Hapus Stok (Misal buku hilang/rusak parah dan dibuang)
    public function destroy($id)
    {
        $copy = BookCopy::findOrFail($id);
        $copy->delete();
        return back()->with('success', 'Stok buku berhasil dihapus.');
    }
}