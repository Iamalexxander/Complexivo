<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';
    protected $primaryKey = 'id_movimiento';

    protected $fillable = [
        'id_inventario',
        'id_usuario',
        'tipo',
        'cantidad',
        'observaciones',
    ];

    protected $casts = [
        'cantidad' => 'integer',
    ];

    public function inventario(): BelongsTo
    {
        return $this->belongsTo(Inventario::class, 'id_inventario');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
