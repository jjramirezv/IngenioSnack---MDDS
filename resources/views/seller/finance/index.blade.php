<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="font-extrabold text-2xl text-slate-800 flex items-center gap-2">
                <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Caja y Finanzas
            </h2>
            <a href="{{ route('seller.finance.export') }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm hover:shadow transition-all flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Exportar Histórico (CSV)
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl shadow-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-5 relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div class="z-10">
                    <p class="text-slate-500 font-bold uppercase text-[10px] tracking-widest mb-1">Ingresos Totales</p>
                    <h3 class="text-3xl font-black text-slate-900">S/ {{ number_format($ingresos, 2) }}</h3>
                </div>
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-5 relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
                <div class="z-10">
                    <p class="text-slate-500 font-bold uppercase text-[10px] tracking-widest mb-1">Egresos Totales</p>
                    <h3 class="text-3xl font-black text-slate-900">S/ {{ number_format($egresos, 2) }}</h3>
                </div>
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-red-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            </div>

            <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800 flex items-center gap-5 relative overflow-hidden group hover:shadow-xl transition-shadow">
                <div class="w-16 h-16 bg-slate-800 text-orange-400 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                </div>
                <div class="z-10">
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest mb-1">Balance Neto</p>
                    <h3 class="text-3xl font-black text-white">S/ {{ number_format($balance, 2) }}</h3>
                </div>
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-slate-800 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white shadow-sm rounded-2xl border border-slate-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-black text-lg text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Historial de Egresos
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-black uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Fecha</th>
                                <th class="px-6 py-4">Descripción del Gasto</th>
                                <th class="px-6 py-4 text-right">Monto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($expensesList as $expense)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-500 font-medium">
                                        {{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-800">
                                        {{ $expense->description }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-red-500">
                                        - S/ {{ number_format($expense->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-slate-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                            <p>No hay gastos registrados aún.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-6 shadow-sm rounded-2xl border border-slate-100 sticky top-24">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h3 class="font-black text-lg text-slate-800">Registrar Gasto</h3>
                    </div>
                    
                    <form action="{{ route('seller.finance.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Descripción</label>
                            <input type="text" name="description" placeholder="Ej. Empaques, servilletas..." class="w-full rounded-xl border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 transition-shadow bg-slate-50 px-4 py-3 text-slate-800 font-medium placeholder-slate-400" required>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Monto (S/)</label>
                            <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-14 flex items-center pointer-events-none">
                            <span class="text-slate-400 font-black">S/</span>
                        </div>
                        <input type="number" step="0.10" min="0.1" name="amount" placeholder="0.00" class="w-full rounded-xl border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 transition-shadow bg-slate-50 pl-15 pr-6 py-3 text-slate-800 font-black placeholder-slate-400" required>
                    </div>

                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Fecha</label>
                            <input type="date" name="expense_date" class="w-full rounded-xl border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 transition-shadow bg-slate-50 px-4 py-3 text-slate-800 font-medium" value="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-4">
                            Guardar Egreso
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>