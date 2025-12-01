<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize()
    {
        // Permitir que cualquier usuario autenticado pueda crear productos
        return auth()->check();
    }

    public function rules()
    {
        return [
            'codigo' => 'required|string|unique:productos,codigo',
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'Este código ya está registrado.',
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
        ];
    }
}
