<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventarios';
    protected $primaryKey = 'id_inventario';

    protected $fillable = [
        'id_producto',
        'id_sucursal',
        'stock_actual',
        'stock_minimo',
    ];

    protected $casts = [
        'stock_actual' => 'integer',
        'stock_minimo' => 'integer',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class, 'id_inventario');
    }

    public function bajoDeMinimoAttribute(): bool
    {
        return $this->stock_actual < $this->stock_minimo;
    }
}
