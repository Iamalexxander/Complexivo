@extends('layouts.app')

@section('title', 'Inventario')

@section('content')
<div class="flex justify-between mb-4">
    <h1 class="text-2xl font-bold">Inventario</h1>
    <a href="{{ route('inventarios.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        <i class="fas fa-plus mr-1"></i> Agregar Inventario
    </a>
</div>

<form method="GET" class="mb-4 flex items-center space-x-2">
    <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar producto..." class="border px-3 py-2 rounded w-full md:w-1/3">
    <label class="flex items-center space-x-1">
        <input type="checkbox" name="stock_bajo" value="1" {{ request('stock_bajo') ? 'checked' : '' }} class="form-checkbox">
        <span>Stock bajo</span>
    </label>
    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700">Filtrar</button>
</form>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2">Código</th>
            <th class="px-4 py-2">Nombre</th>
            <th class="px-4 py-2">Stock Actual</th>
            <th class="px-4 py-2">Stock Mínimo</th>
            <th class="px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($inventarios as $inv)
            <tr class="{{ $inv->stock_actual < $inv->stock_minimo ? 'bg-red-100' : '' }}">
                <td class="border px-4 py-2">{{ $inv->producto->codigo }}</td>
                <td class="border px-4 py-2">{{ $inv->producto->nombre }}</td>
                <td class="border px-4 py-2">{{ $inv->stock_actual }}</td>
                <td class="border px-4 py-2">{{ $inv->stock_minimo }}</td>
                <td class="border px-4 py-2 space-x-2">
                    <a href="{{ route('inventarios.edit', $inv->id_inventario) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="border px-4 py-2 text-center">No hay registros</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $inventarios->links() }}
</div>
@endsection
