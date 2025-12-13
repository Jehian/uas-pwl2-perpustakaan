@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Tambah Kategori Baru</h4>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary rounded-pill px-4">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm rounded-3" style="max-width: 600px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Nama Kategori</label>
                    <input type="text" name="name" class="form-control form-control-lg" 
                           placeholder="Misal: Novel, Sains, Sejarah..." required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">
                    Simpan Kategori
                </button>
            </form>
        </div>
    </div>
</div>
@endsection