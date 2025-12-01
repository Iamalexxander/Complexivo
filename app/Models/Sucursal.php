<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';
    protected $primaryKey = 'id_sucursal';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function inventarios(): HasMany
    {
        return $this->hasMany(Inventario::class);
    }
}
