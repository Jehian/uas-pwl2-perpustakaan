@extends('layouts.public')

@section('content')

<div class="main-header text-center text-white shadow-sm" style="background: linear-gradient(135deg, #0d6efd, #0a58ca); padding: 5rem 0;">
    <div class="container">
        <h1 class="fw-bold display-5 mb-3">Jelajahi Dunia Pengetahuan</h1>
        <p class="lead opacity-75 mb-4">Temukan ribuan koleksi buku menarik di perpustakaan digital kami.</p>
        
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form action="{{ route('public.catalog') }}" method="GET">
                    <div class="input-group input-group-lg bg-white rounded-pill p-1 shadow">
                        <input type="text" name="search" class="form-control border-0 rounded-pill ps-4" 
                               placeholder="Cari judul, penulis, atau kategori..." 
                               value="{{ request('search') }}"
                               style="box-shadow: none;">
                        <button class="btn btn-primary rounded-pill px-4 fw-bold m-1" type="submit">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                    </div>
                </form>
                
                @if(request('search'))
                    <div class="mt-3">
                        <span class="badge bg-light text-dark rounded-pill px-3 py-2 fw-normal">
                            Hasil pencarian: "<strong>{{ request('search') }}</strong>"
                            <a href="{{ route('public.catalog') }}" class="text-danger ms-2 text-decoration-none">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        @forelse($books as $book)
            @php
                $stokTersedia = $book->copies->where('status', 'available')->count();
            @endphp

            <div class="col-6 col-md-3 col-lg-2">
                <div class="card h-100 border-0 shadow-sm book-card position-relative overflow-hidden">
                    
                    <span class="position-absolute top-0 start-0 badge bg-primary m-2 shadow-sm" style="font-size: 10px;">
                        {{ $book->category->name ?? 'Umum' }}
                    </span>

                    <span class="position-absolute top-0 end-0 badge m-2 shadow-sm {{ $stokTersedia > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $stokTersedia > 0 ? $stokTersedia.' Tersedia' : 'Habis' }}
                    </span>

                    <div style="height: 240px; overflow: hidden; background: #f8f9fa;" class="d-flex align-items-center justify-content-center">
                        @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" class="w-100 h-100 object-fit-cover" alt="{{ $book->title }}">
                        @else
                            <div class="text-center text-muted opacity-50">
                                <i class="fas fa-book fa-3x mb-2"></i><br>No Cover
                            </div>
                        @endif
                    </div>

                    <div class="card-body p-3 d-flex flex-column">
                        <h6 class="card-title fw-bold text-dark mb-1 text-truncate" title="{{ $book->title }}">
                            {{ $book->title }}
                        </h6>
                        <small class="text-muted d-block text-truncate mb-2">
                            <i class="fas fa-pen-nib me-1 text-primary"></i> {{ $book->author }}
                        </small>
                        
                        <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-auto rounded-pill fw-bold" 
                                data-bs-toggle="modal" data-bs-target="#bookModal-{{ $book->id }}">
                            <i class="fas fa-eye me-1"></i> Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="bookModal-{{ $book->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="modal-header bg-light border-0">
                            <h5 class="modal-title fw-bold text-primary">
                                <i class="fas fa-book me-2"></i> Detail Buku
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="row g-0">
                                <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4">
                                    @if($book->cover)
                                        <img src="{{ asset('storage/' . $book->cover) }}" class="img-fluid rounded shadow" 
                                             style="max-height: 300px; object-fit: cover;" alt="{{ $book->title }}">
                                    @else
                                        <div class="text-center text-muted">
                                            <i class="fas fa-book fa-5x mb-3"></i><br>Tidak ada cover
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="col-md-7 p-4">
                                    <h3 class="fw-bold mb-2">{{ $book->title }}</h3>
                                    <p class="text-muted mb-3">
                                        <span class="badge bg-info text-dark me-2">{{ $book->category->name ?? 'Umum' }}</span>
                                        <i class="fas fa-calendar-alt me-1"></i> Tahun: {{ $book->publication_year }}
                                    </p>

                                    <div class="mb-4">
                                        <h6 class="fw-bold text-secondary text-uppercase small ls-1">Informasi Penulis & Penerbit</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-1"><i class="fas fa-user-edit me-2 text-primary" width="20"></i> <strong>Penulis:</strong> {{ $book->author }}</li>
                                            <li class="mb-1"><i class="fas fa-building me-2 text-primary" width="20"></i> <strong>Penerbit:</strong> {{ $book->publisher ?? '-' }}</li>
                                        </ul>
                                    </div>

                                    <div class="alert {{ $stokTersedia > 0 ? 'alert-success' : 'alert-danger' }} d-flex align-items-center" role="alert">
                                        @if($stokTersedia > 0)
                                            <i class="fas fa-check-circle fa-2x me-3"></i>
                                            <div>
                                                <strong>Tersedia!</strong><br>
                                                Sisa stok di rak: {{ $stokTersedia }} buku.
                                            </div>
                                        @else
                                            <i class="fas fa-times-circle fa-2x me-3"></i>
                                            <div>
                                                <strong>Stok Habis!</strong><br>
                                                Semua buku sedang dipinjam.
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-grid">
                                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5 bg-white rounded-3 shadow-sm">
                    <i class="fas fa-search fa-4x text-muted mb-3 opacity-25"></i>
                    <h3 class="text-dark fw-bold">Buku tidak ditemukan</h3>
                    <p class="text-muted">Maaf, kami tidak dapat menemukan buku dengan kata kunci tersebut.</p>
                    <a href="{{ route('public.catalog') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                        Lihat Semua Koleksi
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $books->links() }}
    </div>

</div>
@endsection