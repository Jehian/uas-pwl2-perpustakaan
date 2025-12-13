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
        // Tabel Kategori
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Novel, Sains, dll
            $table->timestamps();
        });

        // Tabel Buku (Data Bibliografi)
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_code')->unique(); // Kode Buku Induk
            $table->string('title');
            $table->string('author');
            $table->year('publication_year');
            $table->string('publisher');
            $table->text('description')->nullable();
            $table->string('cover')->nullable(); // Foto Cover
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books_tables');
    }
};
