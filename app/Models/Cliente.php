<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cliente';

    protected $fillable = ['nombre', 'apellido', 'direccion', 'cuit', 'telefono', 'email'];


    public function polizas()
    {
        return $this->hasMany(Poliza::class, 'id_cliente');
    }
}
