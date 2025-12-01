<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    // La clave primaria en la tabla es `id_producto`
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'precio',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    public function inventarios(): HasMany
    {
        return $this->hasMany(Inventario::class);
    }
}
