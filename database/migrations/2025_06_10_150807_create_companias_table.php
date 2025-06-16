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
        Schema::create('companias', function (Blueprint $table) {
            $table->id('id_compania');
            $table->string('nombre_compania');
            $table->enum('tipo_cobertura', [
                'Responsabilidad Civil',
                'Robo e incendio Total',
                'Robo e incendio Total y Parcial',
                'Robo e incendio Total y Parcial, Cristales y Cerraduras',
                'Todo Riesgo (Con franquicia)'
    ]);
    $table->enum('tipo_vigencia', ['Anual', 'Semestral']);
    $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companias');
    }
};
