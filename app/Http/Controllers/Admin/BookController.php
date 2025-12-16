<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class BookController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai Query
        $query = Book::with('category');

        // 2. Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhere('book_code', 'like', '%' . $search . '%');
            });
        }

        // 3. Ambil data (Paginate 7) + Latest
        $books = $query->latest()->paginate(7);
                      
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_code' => 'required|unique:books,book_code',
            'isbn' => 'nullable|string|max:20',
            'title' => 'required',
            'category_id' => 'required',
            'cover' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $data['cover'] = $path;
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function destroy(Book $book)
    {
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }
}