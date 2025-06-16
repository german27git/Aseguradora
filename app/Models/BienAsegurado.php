<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienAsegurado extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion', 'modelo', 'patente', 'valor',
        'motor', 'chasis', 'tipo_vehiculo', 'tipo_uso'
    ];

    public function polizas()
    {
        return $this->hasMany(Poliza::class, 'id_bien_asegurado');
    }
}
