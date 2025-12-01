@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')
<div class="bg-white p-6 shadow rounded">

    <h2 class="text-xl font-bold mb-4">Detalles del Producto</h2>

    <div class="space-y-2">
        <p><strong>Código:</strong> {{ $producto->codigo }}</p>
        <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
        <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
        <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('productos.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
            Volver
        </a>
    </div>
</div>
@endsection
