<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
    ];

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'usuario_id');
    }
}