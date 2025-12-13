<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f3f4f6; font-family: sans-serif; }
        
        /* Sidebar Styling */
        .sidebar {
            background-color: #2c7da0;
            min-height: 100vh;
            color: white;
        }
        .sidebar .brand {
            padding: 20px;
            font-weight: bold;
            font-size: 1.2rem;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .sidebar a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: white;
            color: #2c7da0;
            border-top-left-radius: 25px;
            border-bottom-left-radius: 25px;
            margin-left: 10px;
            font-weight: bold;
        }

        /* Header Styling */
        .top-header {
            background-color: #90a4ae;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar col-md-2 d-none d-md-block">
        <div class="brand">Perpustakaan</div>
        
        <nav class="mt-4">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Home
            </a>
            
            <a href="{{ route('admin.members.index') }}" class="{{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Daftar Member
            </a>
            <a href="{{ route('admin.loans.index') }}" class="{{ request()->routeIs('admin.loans.*') ? 'active' : '' }}">
                <i class="fas fa-book-reader"></i> Daftar Pinjaman
            </a>
            <a href="{{ route('admin.books.index') }}" class="{{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Data Buku
            </a>    
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Kategori Buku
            </a>
        </nav>
    </div>

    <div class="col-md-10 col-12 d-flex flex-column h-100">
        <div class="top-header">
            <h5 class="m-0 fw-bold">PERPUSTAKAAN</h5>
            <div class="d-flex align-items-center gap-3">
                
                <small id="realtime-clock" class="fw-bold text-white" style="letter-spacing: 1px;">
                    Loading...
                </small>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light fw-bold rounded-pill px-3">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="p-4 flex-grow-1">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function updateClock() {
        const now = new Date();
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const dayName = days[now.getDay()];
        
        // Format tanggal: DD-MM-YYYY
        const d = String(now.getDate()).padStart(2, '0');
        const m = String(now.getMonth() + 1).padStart(2, '0');
        const y = now.getFullYear();

        // Format waktu: HH:MM:SS AM/PM
        let h = now.getHours();
        const min = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        const ampm = h >= 12 ? 'PM' : 'AM';

        h = h % 12;
        h = h ? h : 12; // Jam 0 jadi jam 12
        h = String(h).padStart(2, '0');

        // Gabungkan string
        const timeString = `${dayName}, ${d}-${m}-${y} ${h}:${min}:${s} ${ampm}`;
        
        // Update elemen HTML
        document.getElementById('realtime-clock').innerText = timeString;
    }

    // Jalankan setiap 1 detik (1000ms)
    setInterval(updateClock, 1000);
    updateClock(); // Jalankan langsung saat load agar tidak menunggu 1 detik
</script>

</body>
</html>