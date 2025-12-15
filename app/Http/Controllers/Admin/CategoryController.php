<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Category::create($request->all());

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    // --- FITUR BARU 1: UPDATE KATEGORI ---
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Nama kategori berhasil diperbarui!');
    }

    // --- FITUR BARU 2: LIHAT DAFTAR BUKU ---
    public function show(Category $category)
    {
        // Ambil buku yang punya category_id sesuai kategori ini
        $books = $category->books()->with('copies')->latest()->paginate(10);
        
        return view('admin.categories.show', compact('category', 'books'));
    }

    public function destroy(Category $category)
    {
        // Cek dulu, kalau masih ada buku di kategori ini, jangan dihapus
        if($category->books()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Masih ada buku di kategori ini.');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}