@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Tambah Anggota Baru</h4>
        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" required value="{{ old('name') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required value="{{ old('email') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">No. Telepon</label>
                        <input type="number" name="phone" class="form-control" placeholder="0812..." required value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ID Member (Otomatis)</label>
                        <input type="text" class="form-control bg-light" value="Akan digenerate sistem" disabled>
                        <small class="text-muted fst-italic">Kode member (misal: MEM-001) akan dibuat otomatis oleh sistem.</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Foto Profil (Opsional)</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        <small class="text-muted">Format: jpg, png, jpeg. Max 2MB.</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill">
                        <i class="fas fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection