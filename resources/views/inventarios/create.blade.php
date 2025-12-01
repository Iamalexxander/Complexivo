@extends('layouts.app')

@section('title', 'Agregar Inventario')

@section('content')
<h1 class="text-2xl font-bold mb-4">Agregar Producto al Inventario</h1>

<form action="{{ route('inventarios.store') }}" method="POST" class="bg-white p-6 rounded shadow-md space-y-4">
    @csrf

    <div>
        <label class="block mb-1 font-semibold">Producto</label>
        <select name="id_producto" class="w-full border px-3 py-2 rounded">
            <option value="">Seleccione un producto</option>
            @foreach($productos as $producto)
                <option value="{{ $producto->id_producto }}" {{ old('id_producto') == $producto->id_producto ? 'selected' : '' }}>
                    {{ $producto->nombre }} ({{ $producto->codigo }})
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block mb-1 font-semibold">Stock Actual</label>
        <input type="number" name="stock_actual" value="{{ old('stock_actual', 0) }}" class="w-full border px-3 py-2 rounded">
    </div>

    <div>
        <label class="block mb-1 font-semibold">Stock Mínimo</label>
        <input type="number" name="stock_minimo" value="{{ old('stock_minimo', 10) }}" class="w-full border px-3 py-2 rounded">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        <i class="fas fa-plus mr-1"></i> Agregar
    </button>
</form>
@endsection
