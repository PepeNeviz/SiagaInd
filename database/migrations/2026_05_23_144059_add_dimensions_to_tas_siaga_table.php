<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Jalankan: php artisan make:migration add_dimensions_to_tas_siaga_table
// lalu replace isinya dengan ini

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tas_siaga', function (Blueprint $table) {
            $table->decimal('dim_p', 5, 1)->nullable()->after('liter'); // panjang cm
            $table->decimal('dim_l', 5, 1)->nullable()->after('dim_p'); // lebar cm
            $table->decimal('dim_t', 5, 1)->nullable()->after('dim_l'); // tinggi cm
        });
    }

    public function down(): void
    {
        Schema::table('tas_siaga', function (Blueprint $table) {
            $table->dropColumn(['dim_p', 'dim_l', 'dim_t']);
        });
    }
};
