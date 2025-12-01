<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id('id_inventario');
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->onDelete('cascade');
            $table->foreignId('id_sucursal')->constrained('sucursales', 'id_sucursal')->onDelete('cascade');
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_minimo')->default(10);
            $table->timestamps();

            $table->unique(['id_producto', 'id_sucursal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
