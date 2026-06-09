<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú - IngenioSnack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 pb-12">

    <!-- Alertas -->
    <div class="fixed top-4 right-4 z-[60] flex flex-col gap-2">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition class="bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg font-bold flex items-center gap-2 max-w-sm text-sm">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Cálculo del Carrito -->
    @php
        $cartTotal = 0;
        $cartItems = 0;
        if(session()->has('cart')) {
            foreach(session('cart') as $item) {
                $cartTotal += $item['price'] * $item['quantity'];
                $cartItems += $item['quantity'];
            }
        }
    @endphp

    <!-- Barra de Navegación -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span class="font-extrabold text-2xl tracking-tight text-slate-900">Ingenio<span class="text-orange-500">Snack</span></span>
                </div>
                
                <!-- Botones del Lado Derecho -->
                <div class="flex items-center gap-3">
                    
                    <a href="{{ route('cart.index') }}" class="relative flex items-center gap-2 {{ $cartItems > 0 ? 'bg-orange-50 border border-orange-200 text-orange-600' : 'bg-slate-50 border border-slate-200 text-slate-800' }} px-5 py-2 rounded-full font-bold hover:bg-orange-100 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="hidden sm:inline">S/ {{ number_format($cartTotal, 2) }}</span>
                        @if($cartItems > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">{{ $cartItems }}</span>
                        @endif
                    </a>

                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-full font-bold hover:bg-slate-50 transition-colors shadow-sm focus:outline-none">
                                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                <span class="sm:hidden text-lg">👤</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" @click.outside="open = false" x-transition.opacity style="display: none;" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 border border-slate-100 z-50">
                                <div class="px-4 py-2 border-b border-slate-100 sm:hidden">
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                </div>
                                <a href="{{ route('client.orders') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-orange-50 hover:text-orange-600 font-bold transition-colors">
                                    📋 Mis Pedidos
                                </a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 font-medium transition-colors">
                                    ⚙️ Mi Perfil
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 font-bold transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Banner Principal -->
    <div class="bg-slate-900 pb-24 pt-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight">Recarga energías <span class="text-orange-500">sin hacer filas</span></h1>
            <p class="text-slate-300 text-lg max-w-2xl mx-auto font-medium">Pide tu snack antes de que termine la clase, recoge al instante y aprovecha tu recreo.</p>
        </div>
    </div>

    <!-- SISTEMA DE RECOMPENSAS (NUEVO) -->
    @php
        $activePromotions = \App\Models\Promotion::where('is_active', true)->with(['targetProduct', 'rewardProduct'])->get();
    @endphp

    @if($activePromotions->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20 mb-12">
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-3xl">🎁</span>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight">Tus Recompensas</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($activePromotions as $promo)
                    @auth
                        @php
                            $progress = auth()->user()->promotions()->where('promotion_id', $promo->id)->first()->pivot->progress ?? 0;
                            $percentage = min(($progress / $promo->required_quantity) * 100, 100);
                        @endphp
                        
                        <!-- Tarjeta Alumno Logueado -->
                        <div class="bg-slate-50 rounded-2xl p-5 border {{ $progress >= $promo->required_quantity ? 'border-emerald-400 bg-emerald-50/30' : 'border-slate-200' }} relative overflow-hidden group">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-black text-slate-900 text-lg leading-tight">{{ $promo->name }}</h3>
                                    <p class="text-xs text-slate-500 font-bold mt-1">Compra {{ $promo->required_quantity }} <span class="text-orange-500">{{ $promo->targetProduct->name }}</span> 👉 Gana 1 <span class="text-emerald-500">{{ $promo->rewardProduct->name }}</span></p>
                                </div>
                                <div class="bg-white px-3 py-1.5 rounded-xl shadow-sm border border-slate-100 font-black text-orange-500 text-sm">
                                    {{ $progress }} / {{ $promo->required_quantity }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="w-full bg-slate-200 rounded-full h-3 mb-1 overflow-hidden">
                                    <div class="bg-orange-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $percentage }}%"></div>
                                </div>
                                @if($progress >= $promo->required_quantity)
                                    <p class="text-xs font-black text-emerald-600 mt-2 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        ¡Premio desbloqueado! Se agregará gratis en tu próximo pedido.
                                    </p>
                                @else
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider text-right mt-2">
                                        Te faltan {{ $promo->required_quantity - $progress }} para tu regalo
                                    </p>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Tarjeta Visitante (No Logueado) -->
                        <div class="bg-orange-50/50 rounded-2xl p-5 border border-orange-100">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-black text-orange-900 text-lg leading-tight">{{ $promo->name }}</h3>
                                    <p class="text-xs text-orange-700 font-bold mt-1">Compra {{ $promo->required_quantity }} {{ $promo->targetProduct->name }} 👉 Gana 1 {{ $promo->rewardProduct->name }}</p>
                                </div>
                                <span class="text-2xl opacity-50">🔒</span>
                            </div>
                            <div class="mt-4 pt-3 border-t border-orange-200/50">
                                <a href="{{ route('register') }}" class="text-xs font-black text-orange-600 hover:text-orange-800 transition-colors flex items-center gap-1">
                                    Crea tu cuenta para empezar a acumular puntos
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endauth
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Productos Populares -->
    @if(isset($popularProducts) && $popularProducts->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 {{ $activePromotions->count() > 0 ? 'mt-4' : 'mt-12' }} mb-10 relative z-20">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-orange-100 text-orange-500 p-2 rounded-xl shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </span>
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Los Favoritos de la Semana</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($popularProducts as $popular)
                <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden flex items-center p-4 gap-5">
                    
                    <div class="absolute top-0 right-0 bg-orange-500 text-white text-[10px] font-black px-3 py-1.5 rounded-bl-xl tracking-wider uppercase z-10 shadow-sm">
                        Top Ventas
                    </div>

                    <div class="relative h-28 w-28 bg-slate-50 rounded-xl overflow-hidden flex-shrink-0 border border-slate-100">
                        @if($popular->image_path)
                            <img src="{{ asset('storage/' . $popular->image_path) }}" alt="{{ $popular->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col flex-grow h-full justify-between py-1">
                        <div>
                            <h3 class="font-bold text-slate-900 text-lg leading-tight mb-1 pr-6">{{ $popular->name }}</h3>
                            <p class="text-orange-500 font-black text-base mb-3">S/ {{ number_format($popular->price, 2) }}</p>
                        </div>
                        
                        <form action="{{ route('cart.add', $popular->id) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="w-full bg-slate-50 hover:bg-orange-500 text-slate-700 hover:text-white border border-slate-200 hover:border-orange-500 font-bold py-2 px-4 rounded-xl transition-all duration-200 text-sm flex items-center justify-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Agregar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-b border-slate-100"></div>
    </div>
    @endif

    <!-- Todos los Snacks -->
    <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8 mt-8 relative z-20">
        <h2 class="text-xl font-bold text-slate-500 mb-6 uppercase tracking-wider">Todos los Snacks</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            
            @foreach ($products as $product)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden flex flex-col border border-slate-100 group">
                    
                    <div class="relative h-48 bg-slate-100 overflow-hidden">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                        
                        <div class="absolute top-3 right-3">
                            @if($product->stock_quantity > 0)
                                <span class="px-3 py-1 bg-white/95 backdrop-blur-sm text-emerald-600 text-xs font-extrabold rounded-full shadow-sm border border-emerald-50">
                                    {{ $product->stock_quantity }} en stock
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-500/95 text-white text-xs font-extrabold rounded-full shadow-sm">
                                    Agotado
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1">{{ $product->name }}</h3>
                        <p class="text-sm text-slate-500 flex-grow line-clamp-2">{{ $product->description }}</p>

                        @if($product->stock_quantity <= 0 && isset($product->alternativa))
                            <div class="mt-3 bg-blue-50 border border-blue-100 rounded-lg p-3 flex gap-2 items-start shadow-sm">
                                <span class="text-lg">💡</span>
                                <p class="text-xs font-medium text-blue-800">
                                    Te sugerimos probar: <br><span class="font-bold text-sm">{{ $product->alternativa->name }}</span>
                                </p>
                            </div>
                        @endif

                        <div class="mt-4 flex items-end justify-between">
                            <span class="text-2xl font-black text-slate-900">S/ {{ number_format($product->price, 2) }}</span>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4 w-full m-0 p-0">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 {{ $product->stock_quantity == 0 ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-orange-500 hover:bg-orange-600 text-white shadow-md hover:-translate-y-0.5' }} font-bold py-2.5 px-4 rounded-xl transition-all duration-200" {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                @if($product->stock_quantity > 0)
                                    Agregar
                                @else
                                    Sin stock
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</body>
</html>