<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compania extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_compania';

    // Antes: ['nombre_compania', 'tipo_cobertura', 'tipo_vigencia']
    protected $fillable = ['nombre_compania', 'tipo_vigencia'];

    public function polizas()
    {
        return $this->hasMany(Poliza::class, 'id_compania');
    }

    public function tiposCobertura()
    {
        return $this->belongsToMany(
            TipoCobertura::class,
            'compania_tipo_cobertura',
            'compania_id',       // FK hacia Compania en pivote
            'tipo_cobertura_id', // FK hacia TipoCobertura en pivote
            'id_compania',       // clave local de Compania
            'id'                 // clave de TipoCobertura
        );
    }
}
