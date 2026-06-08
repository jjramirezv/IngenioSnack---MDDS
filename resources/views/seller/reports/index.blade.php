<x-app-layout>
    <x-slot name="header"><h2 class="font-extrabold text-2xl text-slate-800">Reportes y Clientes</h2></x-slot>
    <div class="py-12 max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Módulo Izquierdo: Clientes Fieles (HU08) -->
        <div class="md:col-span-1 bg-white p-6 shadow-sm rounded-2xl border border-slate-100">
            <h3 class="font-black text-lg text-slate-800 mb-4 border-b pb-2">🏆 Top Clientes (Fidelidad)</h3>
            <ul class="space-y-3">
                @foreach($topClients as $client)
                    <li class="flex justify-between items-center bg-orange-50 p-3 rounded-lg">
                        <span class="font-bold text-slate-700">{{ $client->name }}</span>
                        <span class="text-orange-600 font-black text-sm">{{ $client->orders_count }} compras</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Módulo Derecho: Historial de Órdenes (HU16) -->
        <div class="md:col-span-2 bg-white p-6 shadow-sm rounded-2xl border border-slate-100">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="font-black text-lg text-slate-800">📚 Historial de Entregas</h3>
                <span class="bg-slate-900 text-white px-3 py-1 rounded-lg font-bold text-sm">Total Ingresos: S/ {{ number_format($totalIngresos, 2) }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-900 font-black uppercase text-xs">
                        <tr><th class="p-3">Orden</th><th class="p-3">Cliente</th><th class="p-3">Monto</th><th class="p-3">Fecha</th></tr>
                    </thead>
                    <tbody>
                        @foreach($ordersHistory as $order)
                            <tr class="border-b border-slate-50 hover:bg-slate-50">
                                <td class="p-3 font-bold text-slate-900">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="p-3">{{ $order->user->name }}</td>
                                <td class="p-3 font-bold text-emerald-600">S/ {{ number_format($order->total_amount, 2) }}</td>
                                <td class="p-3">{{ $order->updated_at->format('d/m/Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>