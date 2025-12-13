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
        Schema::table('books', function (Blueprint $table) {
            // Tambahkan kolom ISBN setelah kolom book_code (agar rapi)
            // Kita buat nullable (boleh kosong) jaga-jaga kalau ada buku tua tanpa ISBN
            $table->string('isbn')->nullable()->after('book_code');
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('isbn');
        });
    }
};
