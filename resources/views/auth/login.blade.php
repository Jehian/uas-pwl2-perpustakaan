<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body, html { 
            height: 100%; 
            overflow: hidden; 
            background: #fff; 
        }
        
        .login-section { 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            padding: 60px; 
            height: 100vh; 
            overflow-y: auto; 
        }
        
        .image-section { 
            /* WARNA CADANGAN (Akan muncul jika gambar gagal load) */
            background-color: #2c7da0; 
            
            /* GAMBAR LOKAL (Pastikan file ada di public/images/login-bg.jpg) */
            background-image: url("{{ asset('images/login-bg.jpg') }}");
            
            /* Setting agar gambar pas */
            background-size: cover;
            background-position: center;
            height: 100vh;
            
            /* Lengkungan Sudut */
            border-bottom-left-radius: 50px;
            border-top-left-radius: 50px;
        }
        
        .btn-primary { 
            background-color: #2c7da0; 
            border: none; 
            border-radius: 50px; 
            padding: 10px 20px; 
        }
        
        .btn-primary:hover { background-color: #1f5f7a; }
        .form-control { border-radius: 10px; padding: 12px; background: #f8f9fa; border: 1px solid #ddd; }
    </style>
</head>
<body>

    <div class="row h-100 g-0">
        <div class="col-md-5 login-section">
            <h5 class="text-primary fw-bold mb-5">PERPUSTAKAAN</h5>
            
            <div class="mb-4">
                <h2 class="fw-bold">Login</h2>
                <p class="text-muted">Masukan email dan password untuk masuk.</p>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold small">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukan password" required>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">Masuk</button>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Daftar disini</a></small>
            </div>
        </div>

        <div class="col-md-7 image-section"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>