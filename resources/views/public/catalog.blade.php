@extends('layouts.public')

@section('content')
<div class="container">
    
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark mb-3">Jelajahi Koleksi Buku Kami</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('public.catalog') }}" method="GET">
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="text" name="search" class="form-control border-0" 
                               placeholder="Cari judul buku, penulis, atau kategori..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($books as $book)
            @php
                $stokTersedia = $book->copies->where('status', 'available')->count();
            @endphp

            <div class="col-6 col-md-3 col-lg-2">
                <div class="card h-100 border-0 shadow-sm book-card overflow-hidden position-relative">
                    
                    <span class="position-absolute top-0 end-0 badge m-2 {{ $stokTersedia > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $stokTersedia > 0 ? 'Tersedia: '.$stokTersedia : 'Habis' }}
                    </span>

                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" class="cover-img" alt="{{ $book->title }}">
                    @else
                        <div class="cover-img bg-light d-flex align-items-center justify-content-center text-muted">
                            <div class="text-center p-2">
                                <i class="fas fa-book fa-3x mb-2"></i><br>No Cover
                            </div>
                        </div>
                    @endif

                    <div class="card-body p-3">
                        <small class="text-primary fw-bold text-uppercase" style="font-size: 10px;">
                            {{ $book->category->name ?? 'Umum' }}
                        </small>
                        <h6 class="card-title fw-bold text-dark mb-1 mt-1 text-truncate" title="{{ $book->title }}">
                            {{ $book->title }}
                        </h6>
                        <small class="text-muted d-block text-truncate">{{ $book->author }}</small>
                        <small class="text-muted" style="font-size: 11px;">{{ $book->publication_year }}</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Buku tidak ditemukan</h4>
                    <a href="{{ route('public.catalog') }}" class="btn btn-outline-primary mt-2">Lihat Semua Buku</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $books->links() }}
    </div>

</div>
@endsection