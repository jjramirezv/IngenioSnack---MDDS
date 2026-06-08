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

    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span class="font-extrabold text-2xl tracking-tight text-slate-900">Ingenio<span class="text-orange-500">Snack</span></span>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('cart.index') }}" class="relative flex items-center gap-2 {{ $cartItems > 0 ? 'bg-orange-50 border border-orange-200 text-orange-600' : 'bg-slate-50 border border-slate-200 text-slate-800' }} px-5 py-2 rounded-full font-bold hover:bg-orange-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>S/ {{ number_format($cartTotal, 2) }}</span>
                        @if($cartItems > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">{{ $cartItems }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-slate-900 pb-16 pt-12 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight">Recarga energías <span class="text-orange-500">sin hacer filas</span></h1>
            <p class="text-slate-300 text-lg max-w-2xl mx-auto font-medium">Pide tu snack antes de que termine la clase, recoge al instante y aprovecha tu recreo.</p>
        </div>
    </div>

    @if(isset($popularProducts) && $popularProducts->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-10 relative z-20">
        
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