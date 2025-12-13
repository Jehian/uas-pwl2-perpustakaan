<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .book-card { transition: transform 0.2s; cursor: pointer; }
        .book-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .cover-img { height: 280px; object-fit: cover; width: 100%; }
    </style>
</head>
<body>

   <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="fas fa-book-reader me-2"></i> KATALOG PERPUSTAKAAN
            </a>
            <div class="ms-auto">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light text-primary fw-bold btn-sm rounded-pill px-3">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard Admin
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm rounded-pill px-3">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="py-5">
        @yield('content')
    </div>

    <footer class="text-center text-muted py-4 border-top mt-auto bg-white">
        <small>&copy; {{ date('Y') }} Sistem Perpustakaan Digital</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>