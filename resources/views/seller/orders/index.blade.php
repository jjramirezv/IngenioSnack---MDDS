<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight flex items-center gap-2">
                <span class="text-3xl">👨‍🍳</span>
                Monitor de Cocina
            </h2>
            <div class="bg-orange-100 text-orange-600 px-4 py-2 rounded-full font-bold text-sm shadow-sm border border-orange-200">
                {{ $orders->count() }} tickets activos
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

            @if($orders->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($orders as $order)
                        
                        @php
                            // Colores y etiquetas dinámicas según el estado
                            $bgClass = 'bg-white';
                            $borderClass = 'border-slate-200';
                            $badgeClass = 'bg-slate-100 text-slate-600';
                            $badgeText = 'Nuevo Ingreso';
                            $nextStatus = 'preparing';
                            $btnColor = 'bg-blue-500 hover:bg-blue-600';
                            $btnText = 'Empezar a Preparar';

                            if($order->status === 'preparing') {
                                $bgClass = 'bg-blue-50/30';
                                $borderClass = 'border-blue-200';
                                $badgeClass = 'bg-blue-100 text-blue-700';
                                $badgeText = 'En Preparación';
                                $nextStatus = 'ready';
                                $btnColor = 'bg-emerald-500 hover:bg-emerald-600';
                                $btnText = 'Marcar como Listo';
                            } elseif($order->status === 'ready') {
                                $bgClass = 'bg-emerald-50/30';
                                $borderClass = 'border-emerald-300 shadow-emerald-100 shadow-lg';
                                $badgeClass = 'bg-emerald-500 text-white shadow-sm';
                                $badgeText = 'Esperando al Estudiante';
                                $nextStatus = 'completed';
                                $btnColor = 'bg-slate-900 hover:bg-slate-800';
                                $btnText = 'Entregar Pedido';
                            }
                        @endphp

                        <div class="{{ $bgClass }} rounded-2xl shadow-sm border-2 {{ $borderClass }} overflow-hidden flex flex-col transition-all">
                            
                            <div class="p-4 border-b border-slate-100 flex justify-between items-start">
                                <div>
                                    <span class="text-[10px] font-black {{ $badgeClass }} px-2 py-1 rounded-md uppercase tracking-wider mb-2 inline-block">
                                        {{ $badgeText }}
                                    </span>
                                    <h3 class="font-black text-slate-900 text-lg">{{ $order->user->name }}</h3>
                                </div>
                                <span class="text-xs font-bold text-slate-400 bg-white px-2 py-1 rounded-md border border-slate-100">
                                    {{ $order->created_at->format('H:i') }}
                                </span>
                            </div>

                            <div class="p-4 flex-grow bg-white/50">
                                <ul class="divide-y divide-slate-100/50">
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

                            <div class="p-4 border-t border-slate-100 bg-white">
                                <div class="flex justify-between items-center mb-4 text-sm font-black">
                                    <span class="text-slate-400 uppercase tracking-wider text-xs">Total:</span>
                                    <span class="text-slate-900 text-lg">S/ {{ number_format($order->total_amount, 2) }}</span>
                                </div>

                                <div x-data="{ confirmingCancel: false }">
                                    <div x-show="!confirmingCancel" class="flex gap-2">
                                        
                                        <form action="{{ route('seller.orders.status', $order->id) }}" method="POST" class="flex-1 m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $nextStatus }}">
                                            <button type="submit" class="w-full text-white font-bold py-3 rounded-xl shadow-sm transition-colors flex justify-center items-center gap-2 {{ $btnColor }}">
                                                {{ $btnText }}
                                            </button>
                                        </form>
                                        
                                        <button @click.prevent="confirmingCancel = true" type="button" class="w-14 bg-white text-slate-300 hover:text-red-500 border border-slate-200 hover:border-red-200 hover:bg-red-50 font-bold py-3 rounded-xl transition-colors flex justify-center items-center" title="Anular Pedido">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>

                                    <div x-show="confirmingCancel" style="display: none;" class="flex gap-2">
                                        <form action="{{ route('seller.orders.cancel', $order->id) }}" method="POST" class="flex-1 m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-black text-xs uppercase tracking-wider py-3 rounded-xl shadow-md transition-colors flex justify-center items-center">
                                                Anular
                                            </button>
                                        </form>
                                        <button @click.prevent="confirmingCancel = false" type="button" class="w-1/3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black text-xs uppercase tracking-wider py-3 rounded-xl transition-colors">
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
                    <span class="text-5xl mb-4 block">☕</span>
                    <h3 class="text-xl font-black text-slate-800">No hay tickets activos</h3>
                    <p class="text-slate-500 mt-2 font-medium">Todos los pedidos han sido entregados.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>