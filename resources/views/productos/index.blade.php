@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="bg-white p-6 shadow rounded-lg">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Productos</h2>

        <a href="{{ route('productos.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            <i class="fa fa-plus mr-1"></i> Nuevo Producto
        </a>
    </div>

    <!-- Buscador -->
    <form method="GET" action="{{ route('productos.index') }}" class="mb-4">
        <input type="text"
               name="buscar"
               value="{{ request('buscar') }}"
               placeholder="Buscar por código, nombre o descripción"
               class="w-full p-2 border rounded">
    </form>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="min-w-full border bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 border">Código</th>
                    <th class="p-3 border">Nombre</th>
                    <th class="p-3 border">Descripción</th>
                    <th class="p-3 border">Precio</th>
                    <th class="p-3 border w-40">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($productos as $producto)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border">{{ $producto->codigo }}</td>
                    <td class="p-3 border">{{ $producto->nombre }}</td>
                    <td class="p-3 border">{{ Str::limit($producto->descripcion, 40) }}</td>
                    <td class="p-3 border">${{ number_format($producto->precio, 2) }}</td>
                    <td class="p-3 border flex space-x-2">

                        <a href="{{ route('productos.show', $producto->id_producto) }}"
                           class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                            Ver
                        </a>

                        <a href="{{ route('productos.edit', $producto->id_producto) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                            Editar
                        </a>

                        <form action="{{ route('productos.destroy', $producto->id_producto) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Eliminar producto?')"
                               class="bg-red-600 text-white px-3 py-1 rounded text-sm">
                                Eliminar
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">
                        No hay productos registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $productos->links() }}
    </div>

</div>
@endsection
