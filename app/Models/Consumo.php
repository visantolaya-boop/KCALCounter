<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
    protected $fillable = [
        'user_id',
        'alimento_id',
        'comida_numero',
        'gramos',
        'fecha',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }
}
