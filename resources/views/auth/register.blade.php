<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html { height: 100%; overflow: hidden; background: #fff; }
        .login-section { display: flex; flex-direction: column; justify-content: center; padding: 60px; height: 100vh; overflow-y: auto; }
        .image-section { 
            background: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=1000') center/cover;
            height: 100vh;
            border-bottom-left-radius: 50px;
            border-top-left-radius: 50px;
        }
        .btn-primary { background-color: #2c7da0; border: none; border-radius: 50px; padding: 10px 20px; }
        .btn-primary:hover { background-color: #1f5f7a; }
        .form-control { border-radius: 10px; padding: 12px; background: #f8f9fa; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="row h-100 g-0">
        <div class="col-md-5 login-section">
            <h5 class="text-primary fw-bold mb-4">PERPUSTAKAAN</h5>
            
            <div class="mb-4">
                <h2 class="fw-bold">Daftar Akun Baru</h2>
                <p class="text-muted">Lengkapi data untuk menjadi admin.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Admin Perpustakaan" required value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" required value="{{ old('email') }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 4 karakter" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold small">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold mb-3">Daftar Sekarang</button>
                
                <div class="text-center">
                    <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">Login disini</a></small>
                </div>
            </form>
        </div>

        <div class="col-md-7 d-none d-md-block image-section"></div>
    </div>
</body>
</html>