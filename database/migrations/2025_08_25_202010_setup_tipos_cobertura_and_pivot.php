<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Catálogo de tipos de cobertura
        Schema::create('tipos_cobertura', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        // 2) Pivote muchos-a-muchos
        Schema::create('compania_tipo_cobertura', function (Blueprint $table) {
            $table->unsignedBigInteger('compania_id');
            $table->unsignedBigInteger('tipo_cobertura_id');

            $table->primary(['compania_id', 'tipo_cobertura_id']);

            // OJO: companias usa PK 'id_compania'
            $table->foreign('compania_id')
                ->references('id_compania')->on('companias')
                ->cascadeOnDelete();

            $table->foreign('tipo_cobertura_id')
                ->references('id')->on('tipos_cobertura')
                ->cascadeOnDelete();
        });

        // 3) Seed de los valores que hoy tenés como enum
        $tipos = [
            'Responsabilidad Civil',
            'Robo e incendio Total',
            'Robo e incendio Total y Parcial',
            'Robo e incendio Total y Parcial, Cristales y Cerraduras',
            'Todo Riesgo (Con franquicia)',
        ];

        foreach ($tipos as $t) {
            DB::table('tipos_cobertura')->updateOrInsert(
                ['nombre' => $t],
                ['nombre' => $t, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // 4) Backfill: copiar el valor del enum a la pivote
        $map = DB::table('tipos_cobertura')->pluck('id', 'nombre'); // ['nombre' => id]

        DB::table('companias')->select('id_compania', 'tipo_cobertura')->orderBy('id_compania')
            ->chunk(200, function ($rows) use ($map) {
                $insert = [];
                foreach ($rows as $row) {
                    if ($row->tipo_cobertura && isset($map[$row->tipo_cobertura])) {
                        $insert[] = [
                            'compania_id' => $row->id_compania,
                            'tipo_cobertura_id' => $map[$row->tipo_cobertura],
                        ];
                    }
                }
                if ($insert) {
                    DB::table('compania_tipo_cobertura')->insertOrIgnore($insert);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('compania_tipo_cobertura');
        Schema::dropIfExists('tipos_cobertura');
    }
};
