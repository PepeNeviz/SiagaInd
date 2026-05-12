<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tas_siaga', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->index();  // nanti bisa tambah user_id
            // $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // uncomment saat ada login
            $table->string('nama_tas', 100);
            $table->enum('kategori', ['anak', 'remaja', 'dewasa', 'lansia']);
            $table->decimal('liter', 5, 1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tas_siaga');
    }
};
