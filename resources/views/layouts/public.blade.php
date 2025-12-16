<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* CSS Tambahan untuk UI yang lebih cantik */
        body { 
            background-color: #f0f2f5; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Style Kartu Buku */
        .book-card { 
            transition: transform 0.2s, box-shadow 0.2s; 
            cursor: pointer; 
            border: 1px solid rgba(0,0,0,0.05) !important;
            border-radius: 12px;
            background: white;
        }
        .book-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
        }
        
        /* Style Gambar Cover */
        .cover-img { 
            height: 250px; 
            object-fit: cover; 
            width: 100%;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        /* Header Gradient (Dipakai di halaman catalog) */
        .main-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 4rem 0;
            margin-bottom: 2rem;
        }
        
        /* Input Pencarian Keren */
        .search-input-group .form-control {
            border-top-left-radius: 30px !important;
            border-bottom-left-radius: 30px !important;
            padding-left: 20px;
        }
        .search-input-group .btn {
            border-top-right-radius: 30px !important;
            border-bottom-right-radius: 30px !important;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="fas fa-book-reader me-2"></i> KATALOG PERPUSTAKAAN
            </a>
            
            </div>
    </nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="bg-white text-center py-4 mt-5 shadow-sm border-top">
        <div class="container">
            <p class="mb-0 text-muted small">
                &copy; {{ date('Y') }} Sistem Perpustakaan Digital. 
                <br>Dibuat untuk keperluan manajemen perpustakaan.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>