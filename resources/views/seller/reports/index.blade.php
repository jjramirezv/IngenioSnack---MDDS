<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 flex items-center gap-2">
            <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Reportes e Inteligencia de Negocio
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 uppercase">Ingresos Históricos</p>
                    <h3 class="text-3xl font-black text-slate-800">S/ {{ number_format($totalIngresos, 2) }}</h3>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 uppercase">Total Pedidos Entregados</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $ordersHistory->count() }} pedidos</h3>
                </div>
            </div>
        </div>

        @if($apiError)
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ $apiError }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h3 class="font-black text-xl text-slate-800">Proyección de Demanda (Motor Prophet AI)</h3>
                    <p class="text-sm text-slate-500 font-medium">Histórico de 30 días + Predicción a 15 días aprendiendo de tu calendario.</p>
                </div>
                <div class="flex gap-4 text-sm font-bold">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-slate-800"></span> Ventas Reales
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-orange-500"></span> Predicción IA
                    </div>
                </div>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="predictionChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-black text-lg text-slate-800">Historial de Ventas</h3>
                </div>
                <div class="overflow-x-auto max-h-[400px]">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-black uppercase text-[10px] tracking-wider sticky top-0">
                            <tr>
                                <th class="px-6 py-4">Orden</th>
                                <th class="px-6 py-4">Fecha</th>
                                <th class="px-6 py-4">Cliente</th>
                                <th class="px-6 py-4 text-right">Monto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($ordersHistory as $order)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3 font-bold text-slate-800">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-3">{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-3">{{ $order->user->name }}</td>
                                    <td class="px-6 py-3 text-right font-black text-slate-900">S/ {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-slate-400 font-bold">No hay ventas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-orange-50/50">
                    <h3 class="font-black text-lg text-slate-800 flex items-center gap-2">
                        <span>🏆</span> Clientes VIP (Top 5)
                    </h3>
                </div>
                <div class="p-4">
                    <ul class="space-y-4">
                        @forelse($topClients as $index => $client)
                            <li class="flex flex-col p-4 rounded-xl {{ $index == 0 ? 'bg-orange-100 border border-orange-200 shadow-sm' : 'bg-slate-50 border border-slate-100' }}">
                                
                                <div class="flex items-center justify-between mb-3 border-b {{ $index == 0 ? 'border-orange-200/50' : 'border-slate-200' }} pb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center font-black text-xs shadow-sm">
                                            #{{ $index + 1 }}
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-800 text-sm">{{ $client->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="block font-black text-orange-600 text-base">{{ $client->orders_count }} pedidos</span>
                                    </div>
                                </div>

                                <div class="pl-11 flex flex-col gap-2 text-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-slate-500">Favorito:</span>
                                        <span class="font-bold text-slate-800 flex items-center gap-1">
                                            {{ $client->favorite_product }} 
                                            <span class="bg-slate-200 text-slate-600 px-1.5 py-0.5 rounded text-[10px]">{{ $client->favorite_product_qty }}x</span>
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-start justify-between mt-1">
                                        <span class="font-bold text-slate-500">Día Pico:</span>
                                        <div class="text-right flex flex-col items-end">
                                            <span class="font-bold text-slate-800">
                                                {{ $client->peak_date ? \Carbon\Carbon::parse($client->peak_date)->format('d/m/Y') : 'N/A' }}
                                            </span>
                                            
                                            @if($client->peak_event !== 'Día Normal')
                                                <span class="mt-1 bg-blue-100 text-blue-700 border border-blue-200 px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider shadow-sm flex items-center gap-1">
                                                    🎯 {{ $client->peak_event }}
                                                </span>
                                            @else
                                                <span class="mt-1 text-slate-400 font-medium text-[10px] italic">Día Normal</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </li>
                        @empty
                            <li class="text-center text-slate-400 py-6 font-bold text-sm">Aún no hay clientes recurrentes.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>

        <div class="mt-8 bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
            <div class="mb-6">
                <h3 class="font-black text-xl text-slate-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    Patrones de Consumo por Temporada
                </h3>
                <p class="text-sm text-slate-500 font-medium mt-1">Descubre qué compran los estudiantes en cada evento académico para planificar tu inventario.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($eventInsights as $insight)
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 relative overflow-hidden group hover:border-orange-300 transition-colors">
                        <div class="absolute top-0 right-0 bg-orange-100 text-orange-600 text-[10px] font-black px-3 py-1 rounded-bl-xl uppercase tracking-wider">
                            Tendencia Alta
                        </div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Durante el evento:</p>
                        <h4 class="text-lg font-black text-slate-800 mb-4 leading-tight">{{ $insight->event_name }}</h4>
                        
                        <div class="flex items-center justify-between bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🔥</span>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Lo más vendido</p>
                                    <p class="font-black text-slate-900">{{ $insight->product_name }}</p>
                                </div>
                            </div>
                            <div class="bg-emerald-100 text-emerald-700 font-black text-sm px-2 py-1 rounded-lg">
                                {{ $insight->quantity }}x
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-slate-50 rounded-2xl p-8 text-center border border-slate-100 dashed">
                        <span class="text-4xl block mb-2">📊</span>
                        <p class="text-slate-500 font-bold">Aún no hay suficientes datos cruzados con el calendario para mostrar tendencias exactas.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const historicalData = @json($historicalData);
            const predictions = @json($predictions);

            let labels = [];
            let realData = [];
            let predictedData = [];

            for (const [date, total] of Object.entries(historicalData)) {
                labels.push(date);
                realData.push(total);
                predictedData.push(null);
            }

            if (labels.length > 0 && predictions.length > 0) {
                let lastRealIndex = labels.length - 1;
                predictedData[lastRealIndex] = realData[lastRealIndex];
            }

            predictions.forEach(pred => {
                if (!labels.includes(pred.fecha)) {
                    labels.push(pred.fecha);
                    realData.push(null);
                    predictedData.push(pred.prediccion_ventas_soles);
                }
            });

            const ctx = document.getElementById('predictionChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Ventas Reales (S/)',
                            data: realData,
                            borderColor: '#1e293b',
                            backgroundColor: 'rgba(30, 41, 59, 0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: '#1e293b',
                            pointRadius: 3,
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Predicción IA (S/)',
                            data: predictedData,
                            borderColor: '#f97316',
                            borderWidth: 3,
                            borderDash: [5, 5],
                            pointBackgroundColor: '#f97316',
                            pointRadius: 3,
                            fill: false,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</x-app-layout>