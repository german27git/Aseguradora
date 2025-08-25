<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCobertura extends Model
{
    protected $table = 'tipos_cobertura'; //  especificar nombre real
    protected $fillable = ['nombre'];

    public function companias()
    {
        return $this->belongsToMany(
            Compania::class,
            'compania_tipo_cobertura',
            'tipo_cobertura_id',
            'compania_id'
        );
    }
}
