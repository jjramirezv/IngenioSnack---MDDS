<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 flex items-center gap-2">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Mis Pedidos y Recompensas
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl shadow-lg p-6 md:p-8 mb-8 text-white relative overflow-hidden border border-slate-700">
            <svg class="absolute -right-10 -bottom-10 w-48 h-48 text-white opacity-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="w-full md:w-1/2">
                    <h3 class="text-xl font-black mb-1 flex items-center gap-2">
                        <span class="text-orange-400">★</span> Club IngenioSnack
                    </h3>
                    <p class="text-slate-300 text-sm mb-4">Acumula 5 compras y llévate una bebida o snack sorpresa totalmente gratis.</p>
                    
                    <div class="w-full bg-slate-700 rounded-full h-3 mb-2">
                        <div class="bg-orange-500 h-3 rounded-full transition-all duration-500" style="width: {{ ($progreso / $meta) * 100 }}%"></div>
                    </div>
                    <p class="text-xs text-slate-400 font-bold text-right">{{ $progreso }} / {{ $meta }} compras para tu regalo</p>
                </div>
                
                <div class="w-full md:w-1/3 flex flex-col items-center justify-center p-4 bg-white/10 rounded-xl backdrop-blur-sm border border-white/20">
                    <span class="text-4xl mb-2">{{ $tarjetasGanadas > 0 ? '🎁' : '🔒' }}</span>
                    <span class="text-sm font-bold text-center">
                        @if($tarjetasGanadas > 0)
                            ¡Tienes <span class="text-orange-400 text-lg">{{ $tarjetasGanadas }}</span> Tarjeta(s) de Regalo!
                        @else
                            Sigue comprando para desbloquear
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <h3 class="text-lg font-black text-slate-800 mb-4 uppercase tracking-wider">Historial de Compras</h3>
        
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-100 p-2 sm:p-6">
            @forelse($misPedidos as $pedido)
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 px-2 sm:px-0 border-b border-slate-100 last:border-0 gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div>
                            <span class="font-black text-slate-900 text-lg block leading-tight">Orden #{{ str_pad($pedido->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <p class="text-sm text-slate-500">{{ $pedido->created_at->format('d/m/Y h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end w-full sm:w-auto">
                        <span class="font-black text-slate-800 mb-2">S/ {{ number_format($pedido->total_amount, 2) }}</span>
                        @if($pedido->status == 'pending')
                            <span class="bg-orange-50 text-orange-600 px-3 py-1 rounded-md font-bold text-xs border border-orange-200">En Preparación ⏳</span>
                        @else
                            <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-md font-bold text-xs border border-emerald-200">Entregado ✅</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-slate-500 font-medium">Aún no has hecho tu primer pedido.</p>
                </div>
            @endforelse
        </div>
        
    </div>
</x-app-layout>