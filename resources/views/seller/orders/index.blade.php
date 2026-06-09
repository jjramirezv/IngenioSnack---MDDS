<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight flex items-center gap-2">
                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Monitor de Pedidos Pendientes
            </h2>
            
            <div class="bg-orange-100 text-orange-600 px-4 py-2 rounded-full font-bold text-sm shadow-sm border border-orange-200">
                {{ $orders->count() }} pedidos en cola
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-500 text-white px-6 py-4 rounded-xl shadow-md font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-sm font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if($orders->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-2xl shadow-sm border-2 border-orange-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                            
                            <div class="bg-orange-50 p-4 border-b border-orange-100 flex justify-between items-start">
                                <div>
                                    <span class="text-xs font-black text-orange-600 uppercase tracking-wider block mb-1">Orden #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <h3 class="font-bold text-slate-900 text-lg">{{ $order->user->name }}</h3>
                                </div>
                                <span class="text-xs font-bold text-slate-500 bg-white px-2 py-1 rounded-md shadow-sm border border-slate-100">
                                    Hace {{ round(\Carbon\Carbon::parse($order->created_at)->diffInMinutes(now())) }} min
                                </span>
                            </div>

                            <div class="p-4 flex-grow bg-white">
                                <ul class="divide-y divide-slate-100">
                                    @foreach($order->products as $product)
                                        <li class="py-2 flex justify-between items-center">
                                            <div class="flex items-center gap-2">
                                                <span class="bg-slate-100 text-slate-700 text-xs font-black px-2 py-1 rounded-md border border-slate-200">{{ $product->pivot->quantity }}x</span>
                                                <span class="text-sm font-bold text-slate-800">{{ $product->name }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="bg-slate-50 p-4 border-t border-slate-100">
                                <div class="flex justify-between items-center mb-1 text-sm">
                                    <span class="text-slate-500 font-medium">Total a cobrar:</span>
                                    <span class="font-bold text-slate-900">S/ {{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-3 text-sm">
                                    <span class="text-slate-500 font-medium">Paga con:</span>
                                    <span class="font-bold text-slate-900">S/ {{ number_format($order->cash_tendered, 2) }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center mb-4 bg-white p-3 rounded-lg border border-slate-200 shadow-inner">
                                    <span class="font-black text-slate-700 text-xs uppercase tracking-wider">VUELTO A ENTREGAR:</span>
                                    <span class="font-black text-emerald-600 text-xl">S/ {{ number_format($order->cash_tendered - $order->total_amount, 2) }}</span>
                                </div>

                                <div x-data="{ confirmingCancel: false }">
                                    
                                    <div x-show="!confirmingCancel" class="flex gap-2">
                                        <form action="{{ route('seller.orders.complete', $order->id) }}" method="POST" class="flex-1 m-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl shadow-md transition-colors flex justify-center items-center gap-2">
                                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Entregar
                                            </button>
                                        </form>
                                        
                                        <button @click.prevent="confirmingCancel = true" type="button" class="w-14 bg-white hover:bg-red-50 text-slate-400 hover:text-red-500 border border-slate-200 hover:border-red-200 font-bold py-3 rounded-xl shadow-sm transition-colors flex justify-center items-center" title="Cancelar Pedido">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>

                                    <div x-show="confirmingCancel" style="display: none;" class="flex gap-2" x-transition>
                                        <form action="{{ route('seller.orders.cancel', $order->id) }}" method="POST" class="flex-1 m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-black text-sm py-3 rounded-xl shadow-md transition-colors flex justify-center items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Confirmar Anulación
                                            </button>
                                        </form>
                                        <button @click.prevent="confirmingCancel = false" type="button" class="w-1/3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-black text-sm py-3 rounded-xl transition-colors">
                                            Volver
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-slate-100 mt-6">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800">Sin pedidos pendientes</h3>
                    <p class="text-slate-500 mt-2 font-medium">Es un buen momento para limpiar el mostrador o revisar el inventario.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>