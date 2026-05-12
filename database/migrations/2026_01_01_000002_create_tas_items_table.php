<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tas_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tas_id')->constrained('tas_siaga')->cascadeOnDelete();
            $table->string('nama_item', 100);
            $table->enum('zona', ['sangat_penting', 'penting', 'cukup_penting']);
            $table->integer('jumlah')->default(1);
            $table->string('satuan', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tas_items');
    }
};
