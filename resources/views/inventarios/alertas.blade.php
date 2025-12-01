@extends('layouts.app')

@section('title', 'Alertas de Stock Bajo')

@section('content')
<h1 class="text-2xl font-bold mb-4">Productos con Stock Bajo</h1>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-red-200">
        <tr>
            <th class="px-4 py-2">Código</th>
            <th class="px-4 py-2">Nombre</th>
            <th class="px-4 py-2">Stock Actual</th>
            <th class="px-4 py-2">Stock Mínimo</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productosStockBajo as $inv)
            <tr class="bg-red-100">
                <td class="border px-4 py-2">{{ $inv->producto->codigo }}</td>
                <td class="border px-4 py-2">{{ $inv->producto->nombre }}</td>
                <td class="border px-4 py-2">{{ $inv->stock_actual }}</td>
                <td class="border px-4 py-2">{{ $inv->stock_minimo }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="border px-4 py-2 text-center">No hay productos con stock bajo</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
