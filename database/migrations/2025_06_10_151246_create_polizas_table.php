<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('polizas', function (Blueprint $table) {
    $table->id('id_poliza');
    $table->string('numero_poliza')->unique();
    $table->enum('estado', ['Vigente', 'Anulada']);
    $table->date('fecha_inicio');
    $table->date('fecha_fin')->nullable();
    $table->enum('seccion', ['Auto', 'Moto']);
    $table->integer('endoso')->default(0);
    
    // Foreign Keys
    $table->unsignedBigInteger('id_cliente');
    $table->unsignedBigInteger('id_compania');
    $table->unsignedBigInteger('id_bien_asegurado');

    $table->timestamps();

    $table->foreign('id_cliente')->references('id_cliente')->on('clientes')->onDelete('cascade');
    $table->foreign('id_compania')->references('id_compania')->on('companias')->onDelete('cascade');
    $table->foreign('id_bien_asegurado')->references('id_bien_asegurado')->on('bien_asegurados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polizas');
    }
};
