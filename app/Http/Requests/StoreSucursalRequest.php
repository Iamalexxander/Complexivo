<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSucursalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/',
            'direccion' => 'required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/',
            'telefono' => 'required|digits:10|numeric|unique:sucursales,telefono',
        ];
    }

    public function messages(): array
    {
        return [
            'regex' => 'required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/',
            'direccion' => 'required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/',
            'telefono' => 'required|digits:10|numeric|unique:sucursales,telefono',
        ];
    }

}
