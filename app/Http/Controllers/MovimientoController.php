<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Inventario;
use App\Http\Requests\StoreMovimientoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $sucursalId = Auth::user()->id_sucursal;

        $query = Movimiento::whereHas('inventario', function($q) use ($sucursalId) {
            $q->where('id_sucursal', $sucursalId);
        })->with(['inventario.producto', 'usuario']);

        // Filtro por tipo
        if ($request->has('tipo') && in_array($request->tipo, ['entrada', 'salida'])) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por fecha
        if ($request->has('fecha_desde') && $request->fecha_desde != '') {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta') && $request->fecha_hasta != '') {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $movimientos = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('movimientos.index', compact('movimientos'));
    }

    public function create()
    {
        $sucursalId = Auth::user()->id_sucursal;

        $inventarios = Inventario::where('id_sucursal', $sucursalId)
            ->with('producto')
            ->get();

        return view('movimientos.create', compact('inventarios'));
    }

    public function store(StoreMovimientoRequest $request)
    {
        DB::beginTransaction();

        try {
            $inventario = Inventario::findOrFail($request->inventario_id);

            // Verificar que el inventario pertenece a la sucursal del usuario
            if ($inventario->id_sucursal != Auth::user()->id_sucursal) {
                throw new \Exception('No autorizado');
            }

            // Validar stock suficiente para salidas
            if ($request->tipo === 'salida' && $inventario->stock_actual < $request->cantidad) {
                throw new \Exception('Stock insuficiente. Disponible: ' . $inventario->stock_actual);
            }

            // Crear el movimiento (usar nombres de columnas reales)
            Movimiento::create([
                'id_inventario' => $request->inventario_id,
                'id_usuario' => Auth::id(),
                'tipo' => $request->tipo,
                'cantidad' => $request->cantidad,
                'observaciones' => $request->observaciones,
            ]);

            // Actualizar el stock
            if ($request->tipo === 'entrada') {
                $inventario->increment('stock_actual', $request->cantidad);
            } else {
                $inventario->decrement('stock_actual', $request->cantidad);
            }

            DB::commit();

            return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Movimiento $movimiento)
    {
        // Verificar que el movimiento pertenece a la sucursal del usuario
        if ($movimiento->inventario->id_sucursal != Auth::user()->id_sucursal) {
            abort(403, 'No autorizado');
        }

        $movimiento->load(['inventario.producto', 'usuario']);

        return view('movimientos.show', compact('movimiento'));
    }
}
