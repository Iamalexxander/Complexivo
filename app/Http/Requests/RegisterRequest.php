<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|min:3|max:100|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Debe ingresar un email válido',
            'email.unique' => 'Este email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden'
        ];
    }
}
