@extends('layouts.app')

@section('title', 'Movimientos')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Movimientos</h1>
    <a href="{{ route('movimientos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        <i class="fas fa-plus mr-1"></i> Nuevo Movimiento
    </a>
</div>

<div class="mb-4">
    <form method="GET" class="flex space-x-2">
        <select name="tipo" class="border rounded px-2 py-1">
            <option value="">Todos los tipos</option>
            <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
            <option value="salida" {{ request('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
        </select>

        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="border rounded px-2 py-1">
        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="border rounded px-2 py-1">

        <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">
            Filtrar
        </button>
    </form>
</div>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4 border-b">ID</th>
            <th class="py-2 px-4 border-b">Producto</th>
            <th class="py-2 px-4 border-b">Tipo</th>
            <th class="py-2 px-4 border-b">Cantidad</th>
            <th class="py-2 px-4 border-b">Usuario</th>
            <th class="py-2 px-4 border-b">Fecha</th>
            <th class="py-2 px-4 border-b">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($movimientos as $mov)
        <tr>
            <td class="py-2 px-4 border-b">{{ $mov->id_movimiento }}</td>
            <td class="py-2 px-4 border-b">{{ $mov->inventario->producto->nombre ?? 'N/A' }}</td>
            <td class="py-2 px-4 border-b capitalize">{{ $mov->tipo }}</td>
            <td class="py-2 px-4 border-b">{{ $mov->cantidad }}</td>
            <td class="py-2 px-4 border-b">{{ $mov->usuario->nombre ?? 'N/A' }}</td>
            <td class="py-2 px-4 border-b">{{ $mov->created_at->format('d/m/Y H:i') }}</td>
            <td class="py-2 px-4 border-b">
                <a href="{{ route('movimientos.show', $mov) }}" class="text-blue-600 hover:underline">Ver</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $movimientos->withQueryString()->links() }}
</div>
@endsection
