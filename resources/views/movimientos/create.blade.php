@extends('layouts.app')

@section('title', 'Nuevo Movimiento')

@section('content')
<h1 class="text-2xl font-bold mb-4">Nuevo Movimiento</h1>

<form action="{{ route('movimientos.store') }}" method="POST" class="bg-white shadow rounded p-6">
    @csrf

    <div class="mb-4">
        <label class="block font-medium mb-1">Producto</label>
        <select name="inventario_id" class="w-full border rounded px-3 py-2">
            <option value="">Seleccione un producto</option>
            @foreach($inventarios as $inv)
                <option value="{{ $inv->id_inventario }}" {{ old('inventario_id') == $inv->id_inventario ? 'selected' : '' }}>
                    {{ $inv->producto->nombre }} (Stock: {{ $inv->stock_actual }})
                </option>
            @endforeach
        </select>
        @error('inventario_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>

    <div class="mb-4">
        <label class="block font-medium mb-1">Tipo</label>
        <select name="tipo" class="w-full border rounded px-3 py-2">
            <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
            <option value="salida" {{ old('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
        </select>
        @error('tipo')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>

    <div class="mb-4">
        <label class="block font-medium mb-1">Cantidad</label>
        <input type="number" name="cantidad" value="{{ old('cantidad') }}" class="w-full border rounded px-3 py-2">
        @error('cantidad')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>

    <div class="mb-4">
        <label class="block font-medium mb-1">Observaciones</label>
        <textarea name="observaciones" class="w-full border rounded px-3 py-2" rows="3">{{ old('observaciones') }}</textarea>
        @error('observaciones')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Guardar
    </button>
</form>
@endsection
