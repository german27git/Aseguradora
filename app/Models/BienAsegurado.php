<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienAsegurado extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_bien_asegurado';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'descripcion', 'modelo', 'patente', 'valor',
        'motor', 'chasis', 'tipo_vehiculo', 'tipo_uso',
        'imagenes', // <-- agregado para múltiples imágenes
    ];

    // Cast para que Laravel maneje 'imagenes' como array
    protected $casts = [
        'imagenes' => 'array',
    ];

    public function polizas()
    {
        return $this->hasMany(Poliza::class, 'id_bien_asegurado');
    }
}
