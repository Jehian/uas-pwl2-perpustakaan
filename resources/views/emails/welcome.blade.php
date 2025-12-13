<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
        <h2 style="color: #0d6efd;">Halo, {{ $member->name }}! 👋</h2>
        
        <p>Selamat bergabung! Akun keanggotaan perpustakaan Anda telah berhasil dibuat.</p>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #0d6efd;">
            <p style="margin: 5px 0;"><strong>ID Anggota:</strong> {{ $member->member_code }}</p>
            <p style="margin: 5px 0;"><strong>Email:</strong> {{ $member->email }}</p>
            <p style="margin: 5px 0;"><strong>No. Telepon:</strong> {{ $member->phone }}</p>
        </div>

        <p>Silakan tunjukkan ID Anggota ini atau sebutkan nama Anda saat ingin meminjam buku di perpustakaan.</p>
        
        <br>
        <p style="font-size: 12px; color: #777;">Salam hangat,<br>Tim Perpustakaan</p>
    </div>
</body>
</html>