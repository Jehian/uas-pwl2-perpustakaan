<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        // 1. Siapkan Query
        $query = Book::with(['category', 'copies']);

        // 2. Logika Pencarian (Judul / Penulis / Kategori)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function($c) use ($search) {
                      $c->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // 3. Ambil data (12 buku per halaman biar rapi di grid)
        $books = $query->latest()->paginate(12)->withQueryString();

        return view('public.catalog', compact('books'));
    }
}