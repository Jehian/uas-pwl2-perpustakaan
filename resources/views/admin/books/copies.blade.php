@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Buku
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4 d-flex gap-4 align-items-center">
            @if($book->cover)
                <img src="{{ asset('storage/' . $book->cover) }}" width="100" class="rounded shadow">
            @endif
            <div>
                <h3 class="fw-bold">{{ $book->title }}</h3>
                <p class="text-muted mb-1">Kode Induk: <strong>{{ $book->book_code }}</strong></p>
                <p class="text-muted mb-0">Total Stok: <strong class="text-primary">{{ $book->copies->count() }} Eksemplar</strong></p>
            </div>
            <div class="ms-auto">
                <form action="{{ route('admin.books.copies.store', $book->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success btn-lg rounded-pill px-4 fw-bold">
                        <i class="fas fa-plus-circle me-2"></i> Tambah 1 Stok
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold m-0">Daftar Fisik Buku (Inventaris)</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Kode Fisik (Barcode)</th>
                        <th>Status</th>
                        <th>Kondisi</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($book->copies as $index => $copy)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td class="fw-bold font-monospace">{{ $copy->copy_code }}</td>
                        <td>
                            @if($copy->status == 'available')
                                <span class="badge bg-success">Tersedia</span>
                            @elseif($copy->status == 'borrowed')
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @else
                                <span class="badge bg-danger">{{ $copy->status }}</span>
                            @endif
                        </td>
                        <td>Baik</td>
                        <td class="text-end pe-4">
                            <form action="{{ route('admin.books.copies.destroy', $copy->id) }}" method="POST"
                                class="d-inline alert-confirm"
                                data-confirm-message="Hapus stok fisik '{{ $copy->copy_code }}'?"
                                data-confirm-text="Ya, Hapus!"
                                data-confirm-color="#dc3545">
                                
                                @csrf 
                                @method('DELETE')
                                
                                {{-- Saya tetap menggunakan btn-outline-danger agar serasi dengan tampilan tabel --}}
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Stok">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            Belum ada stok fisik untuk buku ini. <br> Klik tombol hijau di atas untuk menambah stok.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection