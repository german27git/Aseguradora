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
        Schema::create('operadors', function (Blueprint $table) {
    $table->id('id_operador');
    $table->string('usuario')->unique();
    $table->string('contrasenia'); // En el sistema final usarás bcrypt con Auth
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operadors');
    }
};
