@extends('layouts.app')

@section('title', 'Editar Inventario')

@section('content')
<h1 class="text-2xl font-bold mb-4">Editar Stock Mínimo</h1>

<form action="{{ route('inventarios.update', $inventario->id_inventario) }}" method="POST" class="bg-white p-6 rounded shadow-md space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block mb-1 font-semibold">Producto</label>
        <input type="text" value="{{ $inventario->producto->nombre }} ({{ $inventario->producto->codigo }})" disabled class="w-full border px-3 py-2 rounded bg-gray-100">
    </div>

    <div>
        <label class="block mb-1 font-semibold">Stock Actual</label>
        <input type="number" value="{{ $inventario->stock_actual }}" disabled class="w-full border px-3 py-2 rounded bg-gray-100">
    </div>

    <div>
        <label class="block mb-1 font-semibold">Stock Mínimo</label>
        <input type="number" name="stock_minimo" value="{{ old('stock_minimo', $inventario->stock_minimo) }}" class="w-full border px-3 py-2 rounded">
    </div>

    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yel
