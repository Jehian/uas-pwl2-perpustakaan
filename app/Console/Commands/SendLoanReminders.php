<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoanReminderMail;
use Carbon\Carbon;

class SendLoanReminders extends Command
{
    // Nama perintah yang nanti kita ketik di terminal
    protected $signature = 'loans:send-reminders';

    // Deskripsi perintah
    protected $description = 'Kirim email pengingat ke peminjam yang jatuh tempo besok';

    public function handle()
    {
        $this->info('Sedang mencari peminjaman yang jatuh tempo besok...');

        // 1. Cari Tanggal Besok
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        // 2. Ambil data Loan yang due_date-nya BESOK dan statusnya masih 'active'
        $loans = Loan::whereDate('due_date', $tomorrow)
                     ->where('status', 'active')
                     ->with(['member', 'bookCopy.book']) // Load relasi biar hemat query
                     ->get();

        if ($loans->isEmpty()) {
            $this->info('Tidak ada peminjaman yang jatuh tempo besok.');
            return;
        }

        // 3. Looping dan Kirim Email satu per satu
        foreach ($loans as $loan) {
            $this->info("Mengirim email ke: " . $loan->member->email);

            try {
                Mail::to($loan->member->email)->send(new LoanReminderMail($loan));
            } catch (\Exception $e) {
                $this->error("Gagal kirim ke " . $loan->member->email . ": " . $e->getMessage());
            }
        }

        $this->info('Selesai! Semua pengingat telah dikirim.');
    }
}