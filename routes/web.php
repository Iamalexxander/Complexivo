<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Agrega esta línea
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MovimientoController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('productos.index');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('productos', ProductoController::class);
    Route::get('/api/productos/search', [ProductoController::class, 'search'])->name('productos.search');
    Route::resource('inventarios', InventarioController::class);
    Route::get('/inventarios/alertas/stock-bajo', [InventarioController::class, 'alertas'])->name('inventarios.alertas');
    Route::resource('movimientos', MovimientoController::class);
});
