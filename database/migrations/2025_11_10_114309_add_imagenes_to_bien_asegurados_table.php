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
        Schema::table('bien_asegurados', function (Blueprint $table) {
            $table->json('imagenes')->nullable()->after('tipo_uso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bien_asegurados', function (Blueprint $table) {
            $table->dropColumn('imagenes');
        });
    }
};
