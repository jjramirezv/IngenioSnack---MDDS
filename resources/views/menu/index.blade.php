<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú - IngenioSnack</title>
    <!-- Carga de Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">

    <!-- Navbar / Encabezado -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <!-- Ícono de la marca -->
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span class="font-extrabold text-2xl tracking-tight text-slate-900">Ingenio<span class="text-orange-500">Snack</span></span>
                </div>
                <div>
                    <!-- Botón del carrito flotante (Preparación para HU02) -->
                    <button class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-800 px-5 py-2 rounded-full font-bold transition-colors">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>S/ 0.00</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-slate-900 pb-16 pt-12 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight">Recarga energías <span class="text-orange-500">sin hacer filas</span></h1>
            <p class="text-slate-300 text-lg max-w-2xl mx-auto font-medium">Pide tu snack antes de que termine la clase, recoge al instante y aprovecha tu recreo.</p>
        </div>
        <!-- Decoración abstracta de fondo -->
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-orange-500 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500 rounded-full opacity-10 blur-3xl"></div>
    </div>

    <!-- Contenedor Principal de la Cuadrícula -->
    <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            
            @foreach ($products as $product)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden flex flex-col border border-slate-100 group">
                    
                    <!-- CRITERIO: Mostrar imagen -->
                    <div class="relative h-48 bg-slate-100 overflow-hidden">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <!-- Placeholder mejorado si no hay foto -->
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                                <svg class="w-10 h-10 mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-medium">Foto pendiente</span>
                            </div>
                        @endif
                        
                        <!-- Etiqueta flotante de disponibilidad -->
                        <div class="absolute top-3 right-3">
                            @if($product->stock_quantity > 0)
                                <span class="px-3 py-1 bg-white/95 backdrop-blur-sm text-emerald-600 text-xs font-extrabold rounded-full shadow-sm border border-emerald-50">
                                    {{ $product->stock_quantity }} en stock
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-500/95 backdrop-blur-sm text-white text-xs font-extrabold rounded-full shadow-sm">
                                    Agotado
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <!-- CRITERIO: Listado de snacks -->
                        <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1">{{ $product->name }}</h3>
                        <p class="text-sm text-slate-500 flex-grow line-clamp-2">{{ $product->description }}</p>

                        <div class="mt-4 flex items-end justify-between">
                            <!-- CRITERIO: Mostrar precio -->
                            <div>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-0.5">Precio</span>
                                <span class="text-2xl font-black text-slate-900">S/ {{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>

                        <!-- Botón para la HU02 -->
                        <button class="mt-5 w-full flex items-center justify-center gap-2 {{ $product->stock_quantity == 0 ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-orange-500 hover:bg-orange-600 text-white shadow-md hover:shadow-lg hover:-translate-y-0.5' }} font-bold py-2.5 px-4 rounded-xl transition-all duration-200" {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                            @if($product->stock_quantity > 0)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Agregar
                            @else
                                Sin stock
                            @endif
                        </button>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</body>
</html>