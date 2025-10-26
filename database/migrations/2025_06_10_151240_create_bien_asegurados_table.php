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
        Schema::create('bien_asegurados', function (Blueprint $table) {
    $table->id('id_bien_asegurado');
    $table->string('descripcion');
    $table->integer('modelo');
    $table->string('patente', 10);
    $table->decimal('valor', 12, 2);
    $table->string('motor');
    $table->string('chasis');
    $table->enum('tipo_vehiculo', ['Auto', 'Moto', 'Pick-Up', 'Camiones']);
    $table->enum('tipo_uso', ['Particular', 'Comercial']);
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bien_asegurados');
    }
};
