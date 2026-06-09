<x-app-layout>
    <!-- Contenedor Principal con Alpine.js para las pestañas -->
    <div x-data="{ tab: 'activos' }" class="py-12 bg-slate-50 min-h-screen">
        
        <!-- HEADER DINÁMICO -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h2 class="font-extrabold text-2xl text-slate-800 leading-tight flex items-center gap-3">
                    <span class="text-4xl">👨‍🍳</span>
                    Monitor de Cocina
                </h2>
                
                <!-- El PLUS: Interruptor de Pestañas -->
                <div class="bg-slate-100 p-1.5 rounded-2xl flex items-center gap-1">
                    <button @click="tab = 'activos'" :class="{ 'bg-white shadow-sm text-orange-600 font-black': tab === 'activos', 'text-slate-500 font-bold hover:text-slate-700': tab !== 'activos' }" class="px-5 py-2.5 rounded-xl text-sm transition-all flex items-center gap-2">
                        🔥 En Proceso 
                        <span class="bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full text-xs">{{ $orders->count() }}</span>
                    </button>
                    <button @click="tab = 'historial'" :class="{ 'bg-white shadow-sm text-slate-800 font-black': tab === 'historial', 'text-slate-500 font-bold hover:text-slate-700': tab !== 'historial' }" class="px-5 py-2.5 rounded-xl text-sm transition-all flex items-center gap-2">
                        📋 Historial
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="mb-6 bg-emerald-500 text-white px-6 py-4 rounded-xl shadow-md font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- ========================================== -->
            <!-- PESTAÑA 1: TICKETS ACTIVOS (Diseño Original) -->
            <!-- ========================================== -->
            <div x-show="tab === 'activos'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                @if($orders->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($orders as $order)
                            @php
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
                                                    Confirmar Anulación
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
                        <p class="text-slate-500 mt-2 font-medium">La cocina está limpia por ahora.</p>
                    </div>
                @endif
            </div>

            <!-- ========================================== -->
            <!-- PESTAÑA 2: EL PLUS (Historial de Pedidos)  -->
            <!-- ========================================== -->
            <div x-show="tab === 'historial'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-black text-slate-800 text-lg">Últimos 20 Pedidos Procesados</h3>
                        <span class="text-sm font-bold text-slate-500">Solo lectura</span>
                    </div>
                    
                    @if(isset($historyOrders) && $historyOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-wider text-slate-400 font-black">
                                        <th class="p-4">Hora</th>
                                        <th class="p-4">Estudiante</th>
                                        <th class="p-4">Detalle</th>
                                        <th class="p-4">Total</th>
                                        <th class="p-4 text-right">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($historyOrders as $hOrder)
                                        <tr class="hover:bg-slate-50/80 transition-colors group">
                                            <td class="p-4 text-sm font-bold text-slate-500 whitespace-nowrap">
                                                {{ $hOrder->updated_at->format('H:i a') }}
                                            </td>
                                            <td class="p-4 text-sm font-black text-slate-800">
                                                {{ $hOrder->user->name }}
                                            </td>
                                            <td class="p-4">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($hOrder->products as $p)
                                                        <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-1 rounded-md font-bold border border-slate-200">
                                                            {{ $p->pivot->quantity }}x {{ $p->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="p-4 text-sm font-black text-slate-900">
                                                S/ {{ number_format($hOrder->total_amount, 2) }}
                                            </td>
                                            <td class="p-4 text-right">
                                                @if($hOrder->status === 'completed')
                                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-xs font-black border border-emerald-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Entregado
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-black border border-red-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Anulado
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-16">
                            <span class="text-4xl mb-3 block opacity-50">📭</span>
                            <p class="text-slate-500 font-bold">Aún no hay historial de pedidos procesados hoy.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>