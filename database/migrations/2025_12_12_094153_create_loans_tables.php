<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Tabel Fisik Buku (Copy)
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->string('copy_code')->unique(); // Barcode Unik: B001-C1
            // Status fisik: available (di rak), borrowed (sedang dipinjam), lost (hilang)
            $table->enum('status', ['available', 'borrowed', 'lost', 'damaged'])->default('available');
            $table->timestamps();
        });

        // Tabel Transaksi Peminjaman
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members'); // Siapa yg pinjam
            $table->foreignId('book_copy_id')->constrained('book_copies'); // Fisik mana yg dipinjam
            
            $table->dateTime('loan_date'); // Waktu Pinjam
            $table->dateTime('due_date');  // Batas Waktu
            $table->dateTime('return_date')->nullable(); // Waktu Kembali
            
            // Status transaksi
            $table->enum('status', ['active', 'returned', 'overdue'])->default('active');
            $table->integer('fine')->default(0); // Denda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans_tables');
    }
};
