<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->has('buscar') && $request->buscar != '') {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('nombre', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        $productos = $query->orderBy('nombre')->paginate(15);

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

public function store(StoreProductoRequest $request)
{
    try {
        $data = $request->validated();

        // Crear producto
        $producto = Producto::create($data);

        return redirect()
            ->route('productos.index')
            ->with('success', "Producto '{$producto->nombre}' creado exitosamente.");

    } catch (\Exception $e) {
        // Mostrar el mensaje real del error para depuración
        return back()
            ->withErrors(['error' => 'Error al crear producto: ' . $e->getMessage()])
            ->withInput();
    }
}


    public function show(Producto $producto)
    {
        $producto->load('inventarios.sucursal');
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        try {
            $producto->update($request->validated());
            return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar producto'])->withInput();
        }
    }

    public function destroy(Producto $producto)
    {
        try {
            $producto->delete();
            return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se puede eliminar el producto porque tiene inventario asociado']);
        }
    }

    // API para búsqueda rápida
    public function search(Request $request)
    {
        $term = $request->input('term');

        $productos = Producto::where('nombre', 'like', "%{$term}%")
            ->orWhere('codigo', 'like', "%{$term}%")
            ->limit(10)
            ->get(['id', 'codigo', 'nombre', 'precio']);

        return response()->json($productos);
    }
}
