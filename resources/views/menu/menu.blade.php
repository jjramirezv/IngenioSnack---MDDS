@if($popularProducts->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-8 relative z-20">
        <div class="flex items-center gap-3 mb-6">
            <span class="text-2xl">🔥</span>
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Los Favoritos de la Semana</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b-2 border-slate-100 pb-12">
            @foreach ($popularProducts as $popular)
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-1">
                    <div class="bg-white rounded-xl h-full flex items-center p-4 gap-4">
                        <div class="h-16 w-16 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                            @if($popular->image_path)
                                <img src="{{ asset('storage/' . $popular->image_path) }}" alt="{{ $popular->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold text-slate-900 leading-tight">{{ $popular->name }}</h3>
                            <p class="text-orange-500 font-black text-sm mt-1">S/ {{ number_format($popular->price, 2) }}</p>
                        </div>
                        <form action="{{ route('cart.add', $popular->id) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="bg-orange-100 hover:bg-orange-200 text-orange-600 p-3 rounded-full transition-colors" title="Agregar rápido">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
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
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                                <svg class="w-10 h-10 mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        
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
                        <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1">{{ $product->name }}</h3>
                        <p class="text-sm text-slate-500 flex-grow line-clamp-2">{{ $product->description }}</p>

                        @if($product->stock_quantity <= 0 && isset($product->alternativa))
                            <div class="mt-3 bg-blue-50 border border-blue-100 rounded-lg p-2 flex gap-2 items-start">
                                <span class="text-xl">💡</span>
                                <p class="text-xs font-medium text-blue-800">
                                    Te sugerimos probar: <span class="font-bold">{{ $product->alternativa->name }}</span>
                                </p>
                            </div>
                        @endif

                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <span class="text-2xl font-black text-slate-900">S/ {{ number_format($product->price, 2) }}</span>
                            </div>
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