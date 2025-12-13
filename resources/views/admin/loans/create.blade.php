@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">Buat Peminjaman Baru</h4>
        <a href="{{ route('admin.loans.index') }}" class="btn btn-secondary rounded-pill px-4">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('admin.loans.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Pilih Anggota</label>
                        <select name="member_id" class="form-select" required>
                            <option value="">-- Cari Nama Member --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->member_code }} - {{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Pilih Buku (Tersedia)</label>
                        <select name="book_copy_id" class="form-select" required>
                            <option value="">-- Cari Judul / Kode Buku --</option>
                            @foreach($copies as $copy)
                                <option value="{{ $copy->id }}">
                                    {{ $copy->book->title }} (Kode: {{ $copy->copy_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Durasi Peminjaman</label>
                        <div class="input-group">
                            <input type="number" name="duration" class="form-control" value="7" min="1" required>
                            <span class="input-group-text">Hari</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill mt-3">
                    Proses Peminjaman
                </button>
            </form>
        </div>
    </div>
</div>
@endsection