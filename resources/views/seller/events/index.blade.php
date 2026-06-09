<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 flex items-center gap-2">
            <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Calendario de Demanda
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl shadow-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white shadow-sm rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-black text-lg text-slate-800">Próximos Eventos</h3>
                    <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-bold">{{ $events->count() }} Registrados</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-black uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Evento Académico</th>
                                <th class="px-6 py-4">Fechas</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($events as $event)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-900 block text-base">{{ $event->name }}</span>
                                        @if($event->start_date <= now() && $event->end_date >= now())
                                            <span class="text-[10px] text-emerald-500 font-black bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">EN CURSO</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1 text-xs font-bold text-slate-500">
                                            <span>Desde: <span class="text-slate-800">{{ $event->start_date->format('d/m/Y') }}</span></span>
                                            <span>Hasta: <span class="text-slate-800">{{ $event->end_date->format('d/m/Y') }}</span></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('seller.events.destroy', $event->id) }}" method="POST" class="inline-block" x-data="{ confirming: false }">
                                            @csrf
                                            @method('DELETE')
                                            <button x-show="!confirming" @click.prevent="confirming = true" type="button" class="text-slate-400 hover:text-red-500 transition-colors p-2" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <div x-show="confirming" style="display: none;" class="flex items-center justify-end gap-2">
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-[10px] uppercase font-black px-3 py-1.5 rounded-lg shadow-sm">Borrar</button>
                                                <button @click.prevent="confirming = false" type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] uppercase font-black px-3 py-1.5 rounded-lg">Cancelar</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-slate-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p class="font-bold">El calendario está vacío.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-1">
                
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-6">
                    <div class="flex items-start gap-3">
                        <span class="text-xl">🧠</span>
                        <div>
                            <h4 class="font-black text-blue-900 text-sm mb-1">Entrenamiento de Ventas</h4>
                            <p class="text-xs text-blue-700 font-medium leading-relaxed">Registrar fechas clave ayuda al sistema a aprender tus patrones de venta y generar predicciones más precisas en tus reportes.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 shadow-sm rounded-2xl border border-slate-100 sticky top-24">
                    <h3 class="font-black text-lg text-slate-800 mb-6 border-b border-slate-100 pb-4">Registrar Nuevo Evento</h3>
                    
                    <form action="{{ route('seller.events.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Nombre del Evento</label>
                            <input type="text" name="name" placeholder="Ej. Parciales UNCP 2026-I" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-2.5 px-4 focus:ring-orange-500/20 focus:border-orange-500 font-bold text-sm" required>
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Fecha de Inicio</label>
                                <input type="date" name="start_date" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-2.5 px-3 focus:ring-orange-500/20 font-bold text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Fecha de Fin</label>
                                <input type="date" name="end_date" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-2.5 px-3 focus:ring-orange-500/20 font-bold text-sm" required>
                            </div>
                        </div>
                        @error('end_date') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                        
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 mt-4">
                            Guardar en Calendario
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>