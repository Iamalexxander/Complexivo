<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use App\Http\Requests\StoreInventarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $sucursalId = Auth::user()->id_sucursal;

        $query = Inventario::where('id_sucursal', $sucursalId)
            ->with('producto');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->whereHas('producto', function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%");
            });
        }

        if ($request->stock_bajo == '1') {
            $query->whereColumn('stock_actual', '<', 'stock_minimo');
        }

        $inventarios = $query->orderBy('id_inventario', 'desc')->paginate(15);

        return view('inventarios.index', compact('inventarios'));
    }

    public function create()
    {
        $sucursalId = Auth::user()->id_sucursal;

        $productos = Producto::whereNotIn('id_producto', function($query) use ($sucursalId) {
            $query->select('id_producto')
                  ->from('inventarios')
                  ->where('id_sucursal', $sucursalId);
        })->get();

        return view('inventarios.create', compact('productos'));
    }

    public function store(StoreInventarioRequest $request)
    {
        try {
            $sucursalId = Auth::user()->id_sucursal;

            $existe = Inventario::where('id_producto', $request->id_producto)
                ->where('id_sucursal', $sucursalId)
                ->exists();

            if ($existe) {
                return back()->withErrors(['error' => 'Este producto ya está registrado en su inventario'])->withInput();
            }

            Inventario::create([
                'id_producto' => $request->id_producto,
                'id_sucursal' => $sucursalId,
                'stock_actual' => $request->stock_actual,
                'stock_minimo' => $request->stock_minimo,
            ]);

            return redirect()->route('inventarios.index')->with('success', 'Producto agregado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al agregar el producto'])->withInput();
        }
    }

    public function edit(Inventario $inventario)
    {
        if ($inventario->id_sucursal != Auth::user()->id_sucursal) {
            abort(403, 'No autorizado');
        }

        return view('inventarios.edit', compact('inventario'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        if ($inventario->id_sucursal != Auth::user()->id_sucursal) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'stock_minimo' => 'required|integer|min:1',
        ]);

        $inventario->update([
            'stock_minimo' => $request->stock_minimo,
        ]);

        return redirect()->route('inventarios.index')
            ->with('success', 'Stock mínimo actualizado');
    }

    public function alertas()
    {
        $sucursalId = Auth::user()->id_sucursal;

        $productosStockBajo = Inventario::where('id_sucursal', $sucursalId)
            ->whereColumn('stock_actual', '<', 'stock_minimo')
            ->with('producto')
            ->orderBy('stock_actual')
            ->get();

        return view('inventarios.alertas', compact('productosStockBajo'));
    }
}
