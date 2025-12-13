@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">Tambah Buku Baru</h4>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary rounded-pill px-4">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kode Buku (Induk)</label>
                        <input type="text" name="book_code" class="form-control" placeholder="B-001" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ISBN (Opsional)</label>
                        <input type="text" name="isbn" class="form-control" placeholder="Contoh: 978-602-xxxxx">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Judul Buku</label>
                        <input type="text" name="title" class="form-control" placeholder="Harry Potter..." required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Pengarang</label>
                        <input type="text" name="author" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Penerbit</label>
                        <input type="text" name="publisher" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tahun Terbit</label>
                        <input type="number" name="publication_year" class="form-control" placeholder="2023" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Upload Cover (Opsional)</label>
                        <input type="file" name="cover" class="form-control">
                        <small class="text-muted">Format: jpg, png, jpeg. Max 2MB.</small>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill">Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection