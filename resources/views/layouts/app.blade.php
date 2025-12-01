<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Inventario')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">

    @auth
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <!-- LOGO -->
                <div class="flex items-center">
                    <a href="{{ route('productos.index') }}" class="flex items-center">
                        <i class="fas fa-warehouse text-2xl mr-2"></i>
                        <span class="font-bold text-xl">Sistema de Inventario (COMPLEXIVO) (Alexander Mena)</span>
                    </a>

                    <!-- Menú -->
                    <div class="hidden md:flex ml-10 space-x-4">

                        <a href="{{ route('productos.index') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700
                           {{ request()->routeIs('productos.*') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-box mr-1"></i> Productos
                        </a>

                        <a href="{{ route('inventarios.index') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700
                           {{ request()->routeIs('inventarios.*') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-boxes mr-1"></i> Inventario
                        </a>

                        <a href="{{ route('movimientos.index') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700
                           {{ request()->routeIs('movimientos.*') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-exchange-alt mr-1"></i> Movimientos
                        </a>

                        <a href="{{ route('inventarios.alertas') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700
                           {{ request()->routeIs('inventarios.alertas') ? 'bg-blue-700' : '' }} relative">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Alertas

                            @php
                                $alertasCount = 0;
                                if(Auth::user()->id_sucursal) {
                                    $alertasCount = \App\Models\Inventario::where('id_sucursal', Auth::user()->id_sucursal)
                                        ->whereColumn('stock_actual', '<', 'stock_minimo')
                                        ->count();
                                }
                            @endphp

                            @if($alertasCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs
                                        rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $alertasCount }}
                                </span>
                            @endif
                        </a>

                    </div>
                </div>

                <!-- Usuario -->
                <div class="flex items-center space-x-4">
                    <div class="text-sm">
                        <div class="font-semibold">{{ Auth::user()->nombre }}</div>
                        <div class="text-blue-200 text-xs">{{ Auth::user()->sucursal?->nombre ?? 'Sin sucursal' }}</div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-sign-out-alt mr-1"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>
    @endauth

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
