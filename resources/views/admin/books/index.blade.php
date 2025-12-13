@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Data Buku Induk</h4>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
            <i class="fas fa-plus me-1"></i> Tambah Buku
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="bg-white p-4 rounded-3 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Cover</th>
                        <th>Info Buku</th>
                        <th>Kategori</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $index => $book)
                    <tr>
                        <td class="text-center">{{ $books->firstItem() + $index }}</td>
                        
                        <td class="text-center">
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" height="80" class="rounded shadow-sm">
                            @else
                                <span class="text-muted small">No Cover</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-primary">{{ $book->title }}</div>
                            <small class="text-muted">
                                Kode: {{ $book->book_code }} 
                                @if($book->isbn) | ISBN: {{ $book->isbn }} @endif
                                <br>
                                Oleh: {{ $book->author }} ({{ $book->publication_year }})
                            </small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info text-dark">
                                {{ $book->category->name ?? 'Tidak Ada Kategori' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm btn-info text-white" 
                                        data-bs-toggle="modal" data-bs-target="#detailBookModal-{{ $book->id }}" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <a href="{{ route('admin.books.copies.index', $book->id) }}" class="btn btn-sm btn-success text-white" title="Kelola Stok">
                                    <i class="fas fa-boxes"></i> 
                                </a>

                                <form onsubmit="return confirm('Hapus buku ini?');" 
                                      action="{{ route('admin.books.destroy', $book->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus Buku"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>

                            <div class="modal fade" id="detailBookModal-{{ $book->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title fw-bold">
                                                <i class="fas fa-book me-2"></i> Detail Buku
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row">
                                                <div class="col-md-4 text-center border-end mb-3 mb-md-0">
                                                    @if($book->cover)
                                                        <img src="{{ asset('storage/' . $book->cover) }}" 
                                                             class="img-fluid rounded shadow w-100" 
                                                             style="max-height: 400px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center rounded w-100" style="height: 300px;">
                                                            <span class="text-muted">No Cover Available</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-md-8 ps-md-4 text-start">
                                                    <h3 class="fw-bold text-dark mb-1">{{ $book->title }}</h3>
                                                    <p class="text-muted mb-3">
                                                        <i class="fas fa-user-edit me-1"></i> {{ $book->author }} &nbsp;|&nbsp; 
                                                        <i class="fas fa-calendar me-1"></i> {{ $book->publication_year }}
                                                    </p>
                                                    
                                                    <table class="table table-borderless table-sm mb-3">
                                                        <tr>
                                                            <td width="30%" class="text-muted fw-bold">Kategori</td>
                                                            <td>: <span class="badge bg-info text-dark">{{ $book->category->name ?? '-' }}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-bold">Penerbit</td>
                                                            <td>: {{ $book->publisher }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-bold">ISBN</td>
                                                            <td>: {{ $book->isbn ?? '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-bold">Kode Buku</td>
                                                            <td>: <span class="font-monospace bg-light px-2 py-1 rounded border">{{ $book->book_code }}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-bold">Total Stok</td>
                                                            <td>: <strong>{{ $book->copies->count() }}</strong> Eksemplar</td>
                                                        </tr>
                                                    </table>

                                                    <div class="p-3 bg-light rounded border">
                                                        <h6 class="fw-bold border-bottom pb-2 mb-2">Deskripsi / Sinopsis</h6>
                                                        <p class="mb-0 text-secondary" style="font-size: 0.95rem; line-height: 1.6;">
                                                            {{ $book->description ?? 'Tidak ada deskripsi untuk buku ini.' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4">Belum ada data buku.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
            <div class="mb-2 mb-md-0 text-muted small">
                Menampilkan <span class="fw-bold">{{ $books->firstItem() }}</span> sampai <span class="fw-bold">{{ $books->lastItem() }}</span> dari total <span class="fw-bold">{{ $books->total() }}</span> data
            </div>
            <div>
                {{ $books->links() }}
            </div>
        </div>

    </div>
</div>
@endsection