@extends('layouts.admin')

@section('content')
<div class="bg-white p-4 rounded-3 shadow-sm" style="min-height: 80vh;">
    
    <h4 class="mb-4 fw-bold">Selamat datang di Admin Perpustakaan!</h4>
    <hr>

    <div class="row mb-5">
        <div class="col-md-4">
            <div class="p-4 rounded-3 text-center border" style="background-color: #f8f9fa;">
                <h6 class="fw-bold text-muted">Jumlah Member</h6>
                <h1 class="fw-bold text-primary display-4">{{ $totalMembers ?? 0 }}</h1>
                <i class="fas fa-users text-muted fa-2x mt-2"></i>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="p-4 rounded-3 text-center border" style="background-color: #f8f9fa;">
                <h6 class="fw-bold text-muted">Peminjaman Berjalan</h6>
                <h1 class="fw-bold text-primary display-4">{{ $activeLoans ?? 0 }}</h1>
                <i class="fas fa-book-reader text-muted fa-2x mt-2"></i>
            </div>
        </div>
    </div>

    <h5 class="fw-bold text-secondary mb-3">Peminjaman Berjalan & Terlambat</h5>
    <div class="table-responsive border rounded bg-white">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th class="text-center">Tgl Pinjam</th>
                    <th class="text-center">Jatuh Tempo</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLoans as $loan)
                <tr>
                    <td class="fw-bold text-dark">{{ $loan->member->name }}</td>
                    <td>
                        {{ $loan->bookCopy->book->title }} <br>
                        <small class="text-muted font-monospace">{{ $loan->bookCopy->copy_code }}</small>
                    </td>
                    <td class="text-center text-muted">
                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}
                    </td>
                    <td class="text-center fw-bold">
                        {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                    </td>
                    <td class="text-center">
                        @php
                            // Cek apakah terlambat (Hari ini > Jatuh Tempo)
                            $isOverdue = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($loan->due_date));
                        @endphp

                        @if($isOverdue)
                            <span class="badge bg-danger">Terlambat</span>
                        @else
                            <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fas fa-check-circle text-success mb-2 fs-3"></i><br>
                        Tidak ada peminjaman aktif saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection