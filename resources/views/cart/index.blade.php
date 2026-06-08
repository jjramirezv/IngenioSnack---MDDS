<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Pedido - IngenioSnack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 pb-20">

    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/menu') }}" class="flex items-center gap-2 text-slate-500 hover:text-orange-500 transition-colors font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al Menú
                </a>
                <div class="font-extrabold text-xl tracking-tight text-slate-900">Mi <span class="text-orange-500">Pedido</span></div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        
        @if(count($cart) > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <ul class="divide-y divide-slate-100">
                    
                    @php $total = 0; @endphp
                    
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        
                        <li class="p-4 sm:p-6 flex items-center gap-4 hover:bg-slate-50/50 transition-colors">
                            <div class="h-16 w-16 sm:h-20 sm:w-20 flex-shrink-0 bg-slate-100 rounded-xl overflow-hidden">
                                @if($details['image_path'])
                                    <img src="{{ asset('storage/' . $details['image_path']) }}" alt="{{ $details['name'] }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-slate-400">
                                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">{{ $details['name'] }}</h3>
                                <p class="text-sm text-slate-500 mt-1">S/ {{ number_format($details['price'], 2) }} c/u</p>
                            </div>

                            <div class="text-right">
                                <div class="text-lg sm:text-xl font-black text-slate-900">S/ {{ number_format($details['price'] * $details['quantity'], 2) }}</div>
                                <div class="text-sm font-bold text-orange-500">Cant: {{ $details['quantity'] }}</div>
                            </div>

                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors" title="Quitar del pedido">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
                
                <div class="bg-slate-50 p-6 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="w-full md:w-auto text-center md:text-left">
                        <span class="text-sm font-bold text-slate-500 uppercase tracking-wider block">Total a pagar</span>
                        <span class="text-3xl font-black text-slate-900">S/ {{ number_format($total, 2) }}</span>
                    </div>
                    
                    <form action="{{ route('order.store') }}" method="POST" class="w-full md:w-auto m-0 p-0 flex flex-col sm:flex-row gap-4 items-end">
                        @csrf
                        
                        <div class="w-full sm:w-48 text-left">
                            <label for="cash_tendered" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">¿Con cuánto pagarás?</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 font-bold">S/</span>
                                </div>
                                <input type="number" step="0.10" min="{{ $total }}" name="cash_tendered" id="cash_tendered" placeholder="Ej. 10.00" class="pl-8 block w-full border-slate-300 text-slate-900 font-bold rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors" required>
                            </div>
                        </div>

                        <button type="submit" class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5 text-lg h-[46px]">
                            Confirmar Pedido
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
        @else
            <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-slate-100">
                <div class="mx-auto w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 mb-2">Tu pedido está vacío</h2>
                <p class="text-slate-500 mb-6 font-medium">Aún no has agregado ningún snack a tu canasta.</p>
                <a href="{{ url('/menu') }}" class="inline-flex bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all">
                    Explorar el Menú
                </a>
            </div>
        @endif

    </div>
</body>
</html>