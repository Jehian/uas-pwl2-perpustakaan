@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-3 mb-md-0">Transaksi Peminjaman</h4>
        
        <div class="d-flex gap-2">
            <form action="{{ route('admin.loans.index') }}" method="GET" class="d-flex gap-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari member / buku..." value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-danger" title="Reset Pencarian">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.loans.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold text-nowrap">
                <i class="fas fa-plus me-1"></i> Pinjamkan Buku
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show fw-bold">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="bg-white p-4 rounded-3 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th style="min-width: 150px;">Jatuh Tempo</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $index => $loan)
                    <tr>
                        <td class="text-center">{{ $loans->firstItem() + $index }}</td>
                        
                        <td>
                            @if($loan->member)
                                <div class="fw-bold {{ $loan->member->is_active ? 'text-dark' : 'text-danger' }}">
                                    {{ $loan->member->name }}
                                    
                                    @if(!$loan->member->is_active)
                                        <span class="badge bg-danger" style="font-size: 8px; vertical-align: middle;">Non-Aktif</span>
                                    @endif
                                </div>
                                <small class="text-muted" style="font-size: 11px;">
                                    {{ $loan->member->email }}
                                </small>
                            @else
                                <div class="text-muted fst-italic">
                                    <i class="fas fa-user-slash me-1"></i> Member Terhapus
                                </div>
                                <small class="text-muted" style="font-size: 11px;">Data tidak tersedia</small>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                @if($loan->bookCopy->book->cover)
                                    <img src="{{ asset('storage/' . $loan->bookCopy->book->cover) }}" 
                                         class="rounded me-2" width="40" height="50" style="object-fit: cover;">
                                @endif
                                <div>
                                    <div class="fw-bold text-dark">{{ \Illuminate\Support\Str::limit($loan->bookCopy->book->title, 20) }}</div>
                                    <small class="text-muted font-monospace">{{ $loan->bookCopy->copy_code }}</small>
                                </div>
                            </div>
                        </td>

                        <td class="text-center">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/y') }}</td>
                        
                        <td class="text-center">
                            <div class="{{ $loan->status == 'active' ? 'text-danger fw-bold' : 'text-muted' }}">
                                {{ \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y') }}
                            </div>

                            @if($loan->status == 'active')
                                <button type="button" class="btn btn-sm btn-link text-decoration-none p-0" 
                                        data-bs-toggle="modal" data-bs-target="#editDateModal-{{ $loan->id }}" 
                                        style="font-size: 11px;">
                                    <i class="fas fa-edit"></i> Ubah
                                </button>

                                <div class="modal fade" id="editDateModal-{{ $loan->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Ubah Jatuh Tempo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.loans.update_date', $loan->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body text-start">
                                                    <p>Buku: <strong>{{ $loan->bookCopy->book->title }}</strong></p>
                                                    <div class="form-group mt-3">
                                                        <label class="fw-bold">Pilih Tanggal Baru:</label>
                                                        <input type="date" name="due_date" class="form-control" value="{{ $loan->due_date }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($loan->status == 'active')
                                @if(\Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($loan->due_date)->startOfDay()))
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">Kembali</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm btn-info text-white" 
                                        data-bs-toggle="modal" data-bs-target="#detailModal-{{ $loan->id }}" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>

                                @if($loan->status == 'active')
                                    <form action="{{ route('admin.loans.complete', $loan->id) }}" method="POST"
                                          class="d-inline alert-confirm"
                                          data-confirm-message="Selesaikan peminjaman ini? Stok buku akan bertambah otomatis."
                                          data-confirm-text="Ya, Terima Buku"
                                          data-confirm-color="#198754"
                                          data-confirm-icon="question">
                                        @csrf @method('PUT') 
                                        <button type="submit" class="btn btn-sm btn-success" title="Kembalikan Buku">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled><i class="fas fa-check"></i></button>
                                @endif

                                <form action="{{ route('admin.loans.destroy', $loan->id) }}" method="POST"
                                      class="d-inline alert-confirm"
                                      data-confirm-message="Yakin ingin menghapus riwayat ini? Data yang dihapus tidak bisa dikembalikan."
                                      data-confirm-text="Ya, Hapus!"
                                      data-confirm-color="#dc3545"
                                      data-confirm-icon="warning">
                                    @csrf @method('DELETE') 
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Riwayat">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="modal fade" id="detailModal-{{ $loan->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title fw-bold">
                                                <i class="fas fa-book-reader me-2"></i> Detail Peminjaman
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4 text-start">
                                            <div class="row">
                                                <div class="col-md-5 text-center border-end">
                                                    @if($loan->bookCopy->book->cover)
                                                        <img src="{{ asset('storage/' . $loan->bookCopy->book->cover) }}" 
                                                             class="img-fluid rounded shadow mb-3" style="max-height: 250px;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center rounded mb-3" style="height: 250px;">
                                                            <span class="text-muted">No Cover</span>
                                                        </div>
                                                    @endif
                                                    <h5 class="fw-bold text-primary">{{ $loan->bookCopy->book->title }}</h5>
                                                    <p class="text-muted mb-1">{{ $loan->bookCopy->book->author }}</p>
                                                    <span class="badge bg-dark font-monospace mt-2">{{ $loan->bookCopy->copy_code }}</span>
                                                </div>

                                                <div class="col-md-7 ps-md-4">
                                                    <h6 class="fw-bold border-bottom pb-2 mb-3 text-secondary">DATA PEMINJAM</h6>
                                                    <div class="mb-3">
                                                        <div class="fs-5">{{ $loan->member->name ?? 'Member Terhapus' }}</div>
                                                        <small class="text-muted">{{ $loan->member->email ?? '-' }}</small>
                                                    </div>

                                                    <h6 class="fw-bold border-bottom pb-2 mb-3 mt-4 text-secondary">STATUS TRANSAKSI</h6>
                                                    <div class="row">
                                                        <div class="col-6 mb-3">
                                                            <label class="small text-muted fw-bold">Tanggal Pinjam</label>
                                                            <div class="fw-bold">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d F Y') }}</div>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label class="small text-muted fw-bold">Jatuh Tempo</label>
                                                            <div class="fw-bold text-danger">{{ \Carbon\Carbon::parse($loan->due_date)->format('d F Y') }}</div>
                                                        </div>
                                                    </div>

                                                    <div class="alert {{ $loan->calculated_denda > 0 ? 'alert-danger' : 'alert-success' }} d-flex justify-content-between align-items-center m-0">
                                                        <div>
                                                            <strong>Status:</strong> 
                                                            @if($loan->status == 'returned')
                                                                Dikembalikan
                                                            @elseif($loan->calculated_denda > 0)
                                                                Terlambat
                                                            @else
                                                                Sedang Dipinjam
                                                            @endif
                                                        </div>
                                                        <div class="fs-4 fw-bold">
                                                            Rp {{ number_format($loan->calculated_denda) }}
                                                        </div>
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
                    <tr><td colspan="7" class="text-center py-4">Belum ada transaksi peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
            <div class="mb-2 mb-md-0 text-muted small">
                Menampilkan <span class="fw-bold">{{ $loans->firstItem() }}</span> sampai <span class="fw-bold">{{ $loans->lastItem() }}</span> dari total <span class="fw-bold">{{ $loans->total() }}</span> data
            </div>
            <div>
                {{ $loans->withQueryString()->links() }}
            </div>
        </div>

    </div>
</div>
@endsection