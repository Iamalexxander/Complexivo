<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'inventario_id' => 'required|exists:inventarios,id_inventario',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'observaciones' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'inventario_id.required' => 'Debe seleccionar un producto',
            'inventario_id.exists' => 'El producto seleccionado no existe en el inventario',
            'tipo.required' => 'Debe especificar el tipo de movimiento',
            'tipo.in' => 'El tipo de movimiento debe ser entrada o salida',
            'cantidad.required' => 'La cantidad es obligatoria',
            'cantidad.integer' => 'La cantidad debe ser un número entero',
            'cantidad.min' => 'La cantidad debe ser mayor a 0',
            'observaciones.max' => 'Las observaciones no pueden exceder 500 caracteres',
        ];
    }
}
