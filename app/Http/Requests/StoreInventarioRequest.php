<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_producto' => 'required|exists:productos,id_producto',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'id_producto.required' => 'Debe seleccionar un producto',
            'id_producto.exists' => 'El producto seleccionado no existe',
            'stock_actual.required' => 'El stock actual es obligatorio',
            'stock_actual.integer' => 'El stock actual debe ser un número entero',
            'stock_actual.min' => 'El stock actual no puede ser negativo',
            'stock_minimo.required' => 'El stock mínimo es obligatorio',
            'stock_minimo.integer' => 'El stock mínimo debe ser un número entero',
            'stock_minimo.min' => 'El stock mínimo debe ser al menos 1',
        ];
    }
}
