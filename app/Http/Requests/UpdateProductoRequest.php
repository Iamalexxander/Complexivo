<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Obtener el ID del producto desde la ruta
        $productoId = $this->route('producto')->id_producto ?? $this->route('producto');

        return [
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('productos', 'codigo')->ignore($productoId, 'id_producto'),
            ],
            'nombre' => 'required|string|min:3|max:150',
            'descripcion' => 'required|string|min:10',
            'precio' => 'required|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código es obligatorio',
            'codigo.unique' => 'Este código ya está registrado',
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
            'precio.required' => 'El precio es obligatorio',
            'precio.numeric' => 'El precio debe ser un número',
            'precio.min' => 'El precio debe ser mayor a 0',
        ];
    }
}
