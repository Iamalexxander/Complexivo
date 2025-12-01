<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Añadimos id_sucursal como nullable inicialmente para evitar errores
            $table->foreignId('id_sucursal')->nullable()->constrained('sucursales', 'id_sucursal')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_sucursal');
        });
    }
};
