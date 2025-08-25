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
    Schema::table('polizas', function (Blueprint $table) {
        $table->foreignId('tipo_cobertura_id')
            ->nullable()
            ->constrained('tipos_cobertura')
              ->after('id_compania'); // opcional, para ubicarlo después de la compañía
    });
}

public function down(): void
{
    Schema::table('polizas', function (Blueprint $table) {
        $table->dropForeign(['tipo_cobertura_id']);
        $table->dropColumn('tipo_cobertura_id');
    });
}
};
