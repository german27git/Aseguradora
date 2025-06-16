<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compania extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_compania', 'tipo_cobertura', 'tipo_vigencia'];

    public function polizas()
    {
        return $this->hasMany(Poliza::class, 'id_compania');
    }
}
