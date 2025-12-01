@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="bg-white p-6 shadow rounded">

    <h2 class="text-xl font-bold mb-4">Editar Producto</h2>

    <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="font-semibold">Código</label>
                <input type="text" name="codigo" class="w-full border p-2 rounded"
                       value="{{ $producto->codigo }}" required>
            </div>

            <div>
                <label class="font-semibold">Nombre</label>
                <input type="text" name="nombre" class="w-full border p-2 rounded"
                       value="{{ $producto->nombre }}" required>
            </div>
        </div>

        <div class="mt-4">
            <label class="font-semibold">Descripción</label>
            <textarea name="descripcion" rows="3" class="w-full border p-2 rounded" required>{{ $producto->descripcion }}</textarea>
        </div>

        <div class="mt-4">
            <label class="font-semibold">Precio</label>
            <input type="number" step="0.01" name="precio"
                   class="w-full border p-2 rounded" value="{{ $producto->precio }}" required>
        </div>

        <div class="mt-6 flex space-x-3">
            <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded">
                Actualizar
            </button>

            <a href="{{ route('productos.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                Cancelar
            </a>
        </div>

    </form>
</div>
@endsection
