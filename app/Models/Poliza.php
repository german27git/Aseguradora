<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poliza extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_poliza', 'estado', 'fecha_inicio', 'fecha_fin',
        'seccion', 'endoso', 'id_cliente', 'id_compania', 'id_bien_asegurado'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function compania()
    {
        return $this->belongsTo(Compania::class, 'id_compania');
    }

    public function bienAsegurado()
    {
        return $this->belongsTo(BienAsegurado::class, 'id_bien_asegurado');
    }
}
