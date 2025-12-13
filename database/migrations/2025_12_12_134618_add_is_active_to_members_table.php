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
        // Cek dulu: Kalau kolom 'is_active' BELUM ADA, baru tambahkan
        if (!Schema::hasColumn('members', 'is_active')) {
            Schema::table('members', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('photo');
            });
        }
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
    };
