<!DOCTYPE html>
<html>
<head>
    <title>Pengingat Pengembalian</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
        <h2 style="color: #dc3545;">⚠️ Pengingat Pengembalian Buku</h2>
        
        <p>Halo, <strong>{{ $loan->member->name }}</strong>.</p>
        
        <p>Kami ingin mengingatkan bahwa Anda memiliki buku yang harus dikembalikan <strong>BESOK</strong>.</p>
        
        <div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #ffeeba;">
            <p style="margin: 5px 0;"><strong>Judul Buku:</strong> {{ $loan->bookCopy->book->title }}</p>
            <p style="margin: 5px 0;"><strong>Kode Buku:</strong> {{ $loan->bookCopy->copy_code }}</p>
            <p style="margin: 5px 0;"><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($loan->due_date)->format('d F Y') }}</p>
        </div>

        <p>Mohon kembalikan tepat waktu untuk menghindari denda keterlambatan.</p>
        
        <br>
        <p style="font-size: 12px; color: #777;">Terima kasih,<br>Tim Perpustakaan</p>
    </div>
</body>
</html>