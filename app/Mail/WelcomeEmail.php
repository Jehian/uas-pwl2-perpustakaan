<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Member; // <--- Import Model Member

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $member; // Variabel untuk menampung data member

    // Terima data member saat class ini dipanggil
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    // Judul Email (Subject)
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat Datang di Perpustakaan!',
        );
    }

    // Tampilan Email (View)
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome', // Kita akan buat view ini di langkah 2
        );
    }
}