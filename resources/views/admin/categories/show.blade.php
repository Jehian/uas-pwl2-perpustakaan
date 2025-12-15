@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="text-muted mb-1">Kategori:</h5>
            <h2 class="fw-bold text-primary">{{ $category->name }}</h2>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Cover</th>
                            <th class="px-4 py-3">Judul Buku</th>
                            <th class="px-4 py-3">Penulis</th>
                            <th class="px-4 py-3 text-center">Tahun</th>
                            <th class="px-4 py-3 text-center">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                        <tr>
                            <td class="px-4">
                                @if($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" class="rounded shadow-sm" width="50">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="width: 50px; height: 70px;">
                                        <i class="fas fa-book"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 fw-bold text-dark">
                                {{ $book->title }}
                            </td>
                            <td class="px-4 text-muted">{{ $book->author }}</td>
                            <td class="text-center">{{ $book->publication_year }}</td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ $book->copies->count() }} Pcs</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3"></i><br>
                                Tidak ada buku di kategori ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="p-3">
            {{ $books->links() }}
        </div>
    </div>

</div>
@endsection