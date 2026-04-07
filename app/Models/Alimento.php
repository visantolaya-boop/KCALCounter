<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    protected $fillable = [
        'nombre',
        'kcal_100g',
        'proteinas_100g',
        'carbohidratos_100g',
        'grasas_100g',
    ];

    public function consumos()
    {
        return $this->hasMany(Consumo::class);
    }
}
