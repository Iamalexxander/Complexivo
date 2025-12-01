@extends('layouts.app')

@section('title', 'Detalle Movimiento')

@section('content')
<h1 class="text-2xl font-bold mb-4">Detalle Movimiento #{{ $movimiento->id_movimiento }}</h1>

<div class="bg-white shadow rounded p-6 space-y-3">
    <p><strong>Producto:</strong> {{ $movimiento->inventario->producto->nombre ?? 'N/A' }}</p>
    <p><strong>Tipo:</strong> {{ ucfirst($movimiento->tipo) }}</p>
    <p><strong>Cantidad:</strong> {{ $movimiento->cantidad }}</p>
    <p><strong>Usuario:</strong> {{ $movimiento->usuario->nombre ?? 'N/A' }}</p>
    <p><strong>Fecha:</strong> {{ $movimiento->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Observaciones:</strong> {{ $movimiento->observaciones ?? '-' }}</p>
</div>

<a href="{{ route('movimientos.index') }}" class="mt-4 inline-block bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
    Volver
</a>
@endsection
