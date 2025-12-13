<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk hapus gambar

class BookController extends Controller
{
    public function index()
    {
        // UBAH get() MENJADI paginate(7)
        $books = Book::with('category')
                     ->latest()
                     ->paginate(7); 
                     
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        // Kita butuh data kategori untuk dropdown pilihan
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_code' => 'required|unique:books,book_code',
            'isbn' => 'nullable|string|max:20', // <--- TAMBAHKAN INI
            'title' => 'required',
            'category_id' => 'required',
            'cover' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        // LOGIKA UPLOAD GAMBAR
        if ($request->hasFile('cover')) {
            // Simpan gambar ke folder: storage/app/public/covers
            $path = $request->file('cover')->store('covers', 'public');
            $data['cover'] = $path;
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function destroy(Book $book)
    {
        // Hapus gambar cover lama jika ada
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku dihapus!');
    }
}